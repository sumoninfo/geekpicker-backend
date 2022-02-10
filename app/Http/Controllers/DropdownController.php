<?php

namespace App\Http\Controllers;

use App\Http\Resources\DropdownResource;
use App\Http\Resources\UserDropdownResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class DropdownController extends Controller
{
    /**
     * get type of Dropdown List
     */
    public function getDropDown($model, Request $request): AnonymousResourceCollection
    {
        switch ($model) {
            case 'user':
                return $this->getUsers($request);
            default:
                return $this->getDefaultData($request, $model);
        }
    }


    /**
     * return dropdown users
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function getUsers(Request $request)
    {
        $query = User::query()->where('id', '!=', auth()->id())->take(20);
        if ($request->filled('search')) {
            $query->whereLike(['name', 'email', 'phone'], $request->search);
        }
        return UserDropdownResource::collection($query->get());
    }

    /**
     * return all model by data
     *
     * @param Request $request
     * @param $modelName
     * @return AnonymousResourceCollection
     */
    public function getDefaultData(Request $request, $modelName): AnonymousResourceCollection
    {
        $modelClass = "App\\Models\\" . ucfirst($modelName);
        $query      = $modelClass::select('name', 'id')->take(20);
        if ($request->filled('search')) {
            $query->where('name', 'LIKE', "%{$request->search}%");
        }
        return DropdownResource::collection($query->get());
    }
}
