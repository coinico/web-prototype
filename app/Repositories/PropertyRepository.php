<?php

namespace App\Repositories;

use App\Models\ {
    Property,
    Tag,
    Comment
};
use App\Services\Thumb;

class PropertyRepository
{
    /**
     * The Tag instance.
     *
     * @var \App\Models\Tag
     */
    protected $tag;

    /**
     * The Comment instance.
     *
     * @var \App\Models\Comment
     */
    protected $comment;

    /**
     * The Model instance.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;


    /**
     * Create a new BlogRepository instance.
     *
     * @param  \App\Models\Property $property
     * @param  \App\Models\Tag $tag
     * @param  \App\Models\Comment $comment
     */
    public function __construct(Property $property, Tag $tag, Comment $comment)
    {
        $this->model = $property;
        $this->tag = $tag;
        $this->comment = $comment;
    }


    /**
     * Get active propertys collection paginated.
     *
     * @param  int  $nbrPages
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getActiveOrderByDate($nbrPages)
    {
        return $this->queryActiveOrderByDate()->paginate($nbrPages);
    }

    /**
     * Get all propertys collection paginated.
     *
     * @param  int  $nbrPages
     * @param  array  $parameters
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAll($nbrPages, $parameters)
    {
        return $this->model->with ('ingoing')
            ->orderBy ($parameters['order'], $parameters['direction'])
            ->when ($parameters['active'], function ($query) {
                $query->whereActive (true);
            })->when ($parameters['new'], function ($query) {
                $query->has ('ingoing');
            })->when (auth()->user()->role === 'redac', function ($query) {
                $query->whereHas('user', function ($query) {
                    $query->where('users.id', auth()->id());
                });
            })->paginate ($nbrPages);
    }

    /**
     * Get active propertys for specified tag.
     *
     * @param  int  $nbrPages
     * @param  int  $tag_id
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getActiveOrderByDateForTag($nbrPages, $tag_id)
    {
        return $this->queryActiveOrderByDate()
            ->whereHas('tags', function ($q) use ($tag_id) {
                $q->where('tags.id', $tag_id);
            })->paginate($nbrPages);
    }

    /**
     * Get active propertys for specified tag.
     *
     * @param  int  $nbrPages
     * @param  string  $category_slug
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getActiveOrderByDateForCategory($nbrPages, $category_slug)
    {
        return $this->queryActiveOrderByDate()
            ->whereHas('categories', function ($q) use ($category_slug) {
                $q->where('categories.slug', $category_slug);
            })->paginate($nbrPages);
    }

    /**
     * Get property by slug.
     *
     * @param  string  $slug
     * @return array
     */
    public function getPropertyBySlug($slug)
    {
        // Property for slug with user, tags and categories
        $property = $this->model->with([
            'user' => function ($q) {
                $q->select('id', 'name', 'email');
            }
        ])
        ->whereSlug($slug)
        ->firstOrFail();

        // Previous property
        $property->previous = $this->getPreviousProperty($property->id);

        // Next property
        $property->next = $this->getNextProperty($property->id);

        return compact('property');
    }

    /**
     * Get previous property
     *
     * @param  integer  $id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getPreviousProperty($id)
    {
        return $this->model->select('title', 'slug')->where('id', '<', $id)->latest('id')->first();
    }

    /**
     * Get next property
     *
     * @param  integer  $id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getNextProperty($id)
    {
        return $this->model->select('title', 'slug')->where('id', '>', $id)->oldest('id')->first();
    }

    /**
     * Get propertys with search.
     *
     * @param  int  $n
     * @param  string  $search
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search($n, $search)
    {
        return $this->queryActiveOrderByDate()
            ->where(function ($q) use ($search) {
                $q->where('excerpt', 'like', "%$search%")
                    ->orWhere('body', 'like', "%$search%")
                    ->orWhere('title', 'like', "%$search%");
            })->paginate($n);
    }

    /**
     * Update property.
     *
     * @param  \App\Models\Property  $property
     * @param  \App\Http\Requests\PropertyRequest  $request
     * @return void
     */
    public function update($property, $request)
    {
        //$request->merge(['active' => $request->has('active')]);
        $property->update($request->all());

    }

    /**
     * Store property.
     *
     * @param  \App\Http\Requests\PropertyRequest  $request
     * @return void
     */
    public function store($request)
    {
        $request->merge(['user_id' => auth()->id()]);
        $request->merge(['status_id' => $request->status_id]);

        $property = Property::create($request->all());

    }

    /**
     * Save categories and tags.
     *
     * @param  \App\Models\Property  $property
     * @param  \App\Http\Requests\PropertyRequest  $request
     * @return void
     */
    protected function saveCategoriesAndTags($property, $request)
    {
        $property->categories()->sync($request->categories);

        $tags_id = [];

        if ($request->tags) {
            $tags = explode(',', $request->tags);
            foreach ($tags as $tag) {
                $tag_ref = Tag::firstOrCreate(['tag' => $tag]);
                $tags_id[] = $tag_ref->id;
            }
        }

        $property->tags()->sync($tags_id);
    }
}
