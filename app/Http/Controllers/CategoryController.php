<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use App\Traits\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    use Config;

    private $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * List all categories by workshop
     */
    public function index()
    {
        $categories = $this->repository->findByField('workshop_id', $this->get_user_workshop());

        $scripts[] = 'js/category.js';

        $route = 'categories.index';

        return view('index', compact('categories', 'route', 'scripts'));
    }

    /**
     * List all categories
     */
    public function list_all()
    {
        $categories = $this->repository->all();

        $scripts[] = 'js/category.js';

        $route = 'categories.all';

        return view('index', compact('categories', 'route', 'scripts'));
    }

    /**
     * Create new Category
     */
    public function create()
    {
        $scripts[] = 'js/category.js';

        $route = 'categories.create';

        return view('index', compact( 'route', 'scripts'));
    }

    /**
     * Edit a category
     */
    public function edit($id)
    {
        $scripts[] = 'js/category.js';

        $route = 'categories.edit';

        $category = $this->repository->findByField('id', $id)->first();

        if($category)
        {
            return view('index', compact('category', 'route', 'scripts'));
        }

        Session::flash('error.msg', 'Esta categoria não existe');

        return redirect()->back()->withInput();
    }

    /**
     * Store a new category
     */
    public function store(Request $request)
    {
        $data = $request->all();

        if($this->repository->findByField('name', $data['name'])->first())
        {
            Session::flash('error.msg', 'Esta categoria já existe');

            return redirect()->back()->withInput();
        }

        DB::beginTransaction();

        try{

            $this->repository->create($data);

            DB::commit();

            return redirect()->route('category.index');

        }catch (\Exception $e)
        {
            DB::rollBack();

            return redirect()->back()->withInput();
        }
    }


    /**
     * Update the selected category
     * @param Request $request
     * @param $id
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();

        $category = $this->repository->findByField('id', $id)->first();

        if($category)
        {
            if($category->name != $data['name'])
            {
                if($this->repository->findByField('name', $data['name'])->first())
                {
                    Session::flash('error.msg', 'Esta categoria já existe');

                    return redirect()->back()->withInput();
                }
            }

            DB::beginTransaction();

            try{

                $this->repository->update($data, $id);

                DB::commit();

                return redirect()->route('category.index');

            }catch (\Exception $e)
            {
                DB::rollBack();

                return redirect()->back()->withInput();
            }
        }

    }

    /**
     * Delete the selected category
     * @param $id
     */
    public function delete($id)
    {
        $category = $this->repository->findByField('id', $id)->first();

        DB::beginTransaction();

        try{
            if($category)
            {
                //Find Children categories
                $ch_cat = $this->repository->findByField('parent_category', $id);

                if(count($ch_cat) > 0)
                {
                    foreach ($ch_cat as $item)
                    {
                        $cat['parent_category'] = null;

                        $this->repository->update($cat, $item->id);
                    }
                }

                //Delete the category
                $this->repository->delete($id);

                DB::commit();

                return json_encode(['status' => true]);
            }

        }catch (\Exception $e)
        {
            DB::rollBack();

            return json_encode(['status' => false, 'msg' => $e->getMessage()]);
        }

    }
}











