<?php

namespace App\Services;

use App\Models\Fund;
use App\Models\FundAlias;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class FundService
{
    public function find(array $filters = []): Collection
    {
        $query = Fund::with('fundManager', 'fundManager.company:id,name', 'aliases', 'companies:id,name');

        // Filters
        if (!empty(Arr::get($filters, 'name'))) {
            $query->where('name', 'like', '%' . Arr::get($filters, 'name') . '%');
        }

        if (!empty(Arr::get($filters, 'year'))) {
            $query->where('start_year', Arr::get($filters, 'year'));
        }

        if (!empty(Arr::get($filters, 'fund_manager_id'))) {
            $fundManagerId = Arr::get($filters, 'fund_manager_id');
            $query->whereHas('fundManager', function ($query) use ($fundManagerId) {
                return $query->where('id', $fundManagerId);
            });
        }

        // Get funds
        return $query->get();
    }

    /**
     * @throws \Exception
     */
    public function update(Fund $fund, array $data = []): Fund
    {
        DB::beginTransaction();

        try {
            if (!empty(Arr::get($data, 'name'))) {
                $fund->name = Arr::get($data, 'name');
            }

            if (!empty(Arr::get($data, 'aliases'))) {
                // Save new aliases
                $aliases = collect(Arr::get($data, 'aliases'))->map(function ($alias) use ($fund) {
                    return FundAlias::firstOrCreate([
                        'fund_id' => $fund->id,
                        'alias' => $alias
                    ]);
                });

                // Delete old aliases
                $fund->aliases->diff($aliases)->map->delete();
            }

            if (!empty(Arr::get($data, 'start_year'))) {
                $fund->start_year = Arr::get($data, 'start_year');
            }

            if (!empty(Arr::get($data, 'fund_manager_id'))) {
                $fund->fund_manager_id = Arr::get($data, 'fund_manager_id');
            }

            if (!empty(Arr::get($data, 'companies'))) {
                $fund->companies()->sync(Arr::get($data, 'companies'));
            }

            $fund->save();

            DB::commit();

            $fund->refresh();

            return $fund;

        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }

    public function validateDuplicateFund(Fund $fund): bool
    {
        return $fund->fundManager->funds()->where('name', $fund->name)->count() > 1;
    }
}
