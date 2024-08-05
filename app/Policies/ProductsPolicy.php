<?php

namespace App\Policies;

use App\Models\Products;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductsPolicy
{
    /**
     * Determine whether the user can permanently delete the model.
     */
    public function modify(User $user, Products $products): Response
    {
        return $user->id === $products->user_id
            ? Response::allow()
            : Response::deny('You do not own this product.');
    }
}
