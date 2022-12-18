<?php

namespace App\Http\Controllers;

use App\Exceptions\Slug\SlugException;
use App\Http\Requests\Slug\CreateSlugRequest;
use App\Http\Requests\Slug\DeleteSlugRequest;
use App\Http\Requests\Slug\IndexSlugRequest;
use App\Http\Requests\Slug\ShowSlugRequest;
use App\Http\Requests\Slug\UpdateSlugRequest;
use App\Models\Slug;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SlugController extends Controller
{
    public function index(IndexSlugRequest $request)
    {
        try {
            $slug = Slug::where('user_id', Auth::user()->id)->get();
            $result = [
                'status' => true,
                'data' => $slug->toArray(),
            ];
            return response($result, 200);
        } catch (Exception $e) {
            throw new SlugException($e->getMessage(), 400);
        }
    }

    public function show(ShowSlugRequest $request)
    {
        try {
            $slug = Slug::find($request->slug_id);
            $result = [
               'status' => true,
                'data' => $slug->toArray(),
            ];
            return response($result, 200);
        } catch (Exception $e) {
            throw new SlugException($e->getMessage(), 400);
        }
    }

    public function create(CreateSlugRequest $request)
    {
        try {
            $randomSlug = $request->slug ?? Str::random(11);
            if(Slug::where('slug', $randomSlug)->exists()) {
                throw new SlugException('Slug already exists');
            }

            $slug = new Slug();
            $slug->name = $request->name;
            $slug->link = $request->link;
            $slug->slug = $randomSlug;
            $slug->user_id = Auth::user()->id;
            $slug->save();

            $result = [
                'status' => true,
                'message' => 'Slug created successfully',
                'data' => $slug->toArray(),
            ];
            return response($result, 200);
        } catch (Exception $e) {
            throw new SlugException($e->getMessage(),400);
        }
    }

    public function update(UpdateSlugRequest $request)
    {
        try {
            if (Slug::where('slug', $request->slug)->exists()) {
                throw new SlugException('Slug is already in use');
            }

            $slug = Slug::where('id', $request->slug_id)->update($request->except('slug_id'));
            if (!$slug) {
                throw new SlugException('Slug could not be updated', 400);
            }
            $slug = Slug::find($request->slug_id);

            $result = [
                'status' => true,
                'message' => 'User updated successfully',
                'data' => $slug->toArray(),
            ];

            return response($result, 200);
        } catch (Exception $e) {
            throw new SlugException($e->getMessage(), 400);
        }
    }

    public function destroy(DeleteSlugRequest $request)
    {
        try {
            $slug = Slug::where('id', $request->slug_id)->delete();
            if (!$slug) {
                throw new SlugException('User could not be deleted', 400);
            }
            $result = [
                'status' => true,
                'message' => 'Slug deleted successfully'
            ];
            return response($result, 200);
        } catch (Exception $e) {
            throw new SlugException($e->getMessage(), 400);
        }
    }
}
