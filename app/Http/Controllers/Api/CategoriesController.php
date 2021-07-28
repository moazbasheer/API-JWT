<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Traits\MessagesTrait;
class CategoriesController extends Controller
{
    use MessagesTrait;
    public function index() {
        $categories = Category::select('id', 'name_' . app()->getLocale() . ' as name')->get();

        return response($this->sendSuccessMessage('', $categories), 200);
    }

    public function getCategoryById(Request $req) {
        $category = Category::select('id', 'name_' . app()->getLocale() . ' as name')
                    ->where('id', $req->id)
                    ->first();
        if(!$category) {
            return response($this->sendError('Not found!'), 404);
        }
        
        return response($this->sendSuccessMessage('Found Successfully!', $category), 200);
    }

    public function changeStatus(Request $req) {
        $category = Category::where('id',$req->id)->first();
        if(!$category) {
            return response($this->sendError('Not found!'), 404);
        }
        $category->active = $req->active;
        $category->save();
        
        return response($this->sendSuccessMessage('changed Successfully!', $category), 200);
    }



}
