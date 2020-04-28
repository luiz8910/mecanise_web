<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use App\Repositories\WorkshopRepository;
use App\Traits\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    use Config;

    /**
     * @var ProductRepository
     */
    private $repository;
    /**
     * @var WorkshopRepository
     */
    private $workshopRepository;
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    public function __construct(ProductRepository $repository, WorkshopRepository $workshopRepository,
                                CategoryRepository $categoryRepository)
    {

        $this->repository = $repository;
        $this->workshopRepository = $workshopRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * List all active products the workshop have
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $products = $this->repository->findWhere(['status' => 'active', 'workshop_id' => $this->get_user_workshop()]);

        foreach ($products as $product)
        {
            $product->category = $this->categoryRepository->findByField('id', $product->category_id)->first() ?
                $this->categoryRepository->findByField('id', $product->category_id)->first()->name : null;
        }

        $route = 'products.index';

        $scripts[] = 'product.js';

        return view('index', compact('scripts', 'route', 'products'));
    }

    /**
     * List Products by Categories
     * @param $category_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function list_by_category($category_id)
    {
        $category = $this->categoryRepository->findByField('id', $category_id)->first();

        if($category)
        {
            $products = $this->repository->findWhere(
                [
                    'status' => 'active',
                    'workshop_id' => $this->get_user_workshop(),
                    'category_id' => $category_id
                ]);

            $route = 'products.list_by_category';

            $scripts[] = 'product.js';

            return view('index', compact('category', 'products', 'route', 'scripts'));
        }

        return redirect()->back()->withInput();
    }

    public function create()
    {
        $category = $this->categoryRepository->all();

        $route = 'products.create';

        $scripts[] = 'product.js';

        return view('index', compact('category', 'products', 'route', 'scripts'));
    }

    public function edit($id)
    {
        $category = $this->categoryRepository->all();

        $product = $this->repository->findByField('id', $id)->first();

        if($product)
        {
            $route = 'products.edit';

            $scripts[] = 'product.js';

            return view('index', compact('category', 'product', 'route', 'scripts'));
        }

        return redirect()->back()->withInput();
    }

    public function store(Request $request)
    {
        $data = $request->all();

        DB::beginTransaction();

        try{

            $this->repository->create($data);

            DB::commit();

            $request->session()->flash('success.msg', 'O produto foi cadastrado com sucesso');

            return redirect()->route('products.index');

        }catch (\Exception $e){

            DB::rollBack();

            $request->session()->flash('error.msg', 'Um erro ocorreu, tente novamente mais tarde');

            return redirect()->back()->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        DB::beginTransaction();

        if($this->repository->findByField('id', $id)->first())
        {
            try{

                $this->repository->update($data, $id);

                DB::commit();

                $request->session()->flash('success.msg', 'O produto foi alteraco com sucesso');

                return redirect()->route('products.index');

            }catch (\Exception $e){

                DB::rollBack();

                $request->session()->flash('error.msg', 'Um erro ocorreu, tente novamente mais tarde');

                return redirect()->back()->withInput();
            }
        }

        $request->session()->flash('error.msg', 'Este produto não existe');

        return redirect()->back()->withInput();

    }

    public function delete($id)
    {
        $product = $this->repository->findByField('id', $id)->first();

        if($product)
        {
            DB::beginTransaction();

            try{

                $this->repository->delete($id);

                DB::commit();

                return json_encode(['status' => true]);

            }catch (\Exception $e)
            {
                return json_encode(['status' => false, 'msg' => $e->getMessage()]);
            }

        }

        return json_encode(['status' => false, 'msg' => 'Este produto não existe']);


    }
}
