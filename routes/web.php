<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Support\Facades\DB;
use App\Product;

Route::get('/', 'UserController@index');

Route::get('/index', 'UserController@index');

Route::get('/store/{type}', 'UserController@store');

Route::get('/store', 'UserController@storeAll');

Route::get('/product/{id}', 'UserController@product')->name('product');

Route::get('/checkout', 'UserController@checkout');

Route::get('/login','AccountController@getLogin');

Route::post('/login','AccountController@postLogin')->name('login');

Route::get('/register', 'AccountController@getRegister');

Route::post('/register', 'AccountController@postRegister')->name('register');

Route::get('/forget_password','AccountController@getForgetPassword');

Route::post('/forget_password','AccountController@postForgetPassword')->name('forget');

Route::post('/password_reset','AccountController@postReset')->name('reset');

Route::get('confirm', function(){
	return view('confirm_email');
});

Route::get('confirmuser/{code}', 'AccountController@confirmUser');

Route::get('/logout',function(){
	Cart::instance('shopping')->store(Auth::user()->id);
	Auth::logout();
	Cart::instance('shopping')->destroy();
	return redirect('/');
});
Route::get('/search', [
	'uses' =>'UserController@getSearch',
	'as' => 'search'
	]);
Route::get('/comment/{id}', 'UserController@addComment')->name('comment');

// them vao gio hang

Route::get('add-to-card','UserController@addToCart')->name('addtocard');

Route::get('delete-cart', 'UserController@destroyCart')->name('destroycart');

Route::post('/addorder','UserController@addOrder');


// Route::get('cart/add-to-card/{id}','UserController@addToCart')->name('addtocard');
// Route::get('cart/update-cart/{id}', 'UserController@updateCart')->name('updatecart');
// Route::get('cart/remove/{id}', 'UserController@removeCart')->name('removecart');
// Route::get('cart/delete', 'UserController@destroyCart')->name('destroycart');
Route::get('/information', 'UserController@getUser');

Route::get('/account', 'UserController@getAccount');

Route::group(['prefix'=>'admin','middleware'=>'admin'],
	function(){
		Route::get('/','AdminController@index');
		Route::get('/index','AdminController@index');
		Route::get('information/colors',function(){
			return view('admin.colors');
		});

		Route::get('information/displays',function(){
			return view('admin.displays');
		});

		Route::get('information/storages',function(){
			return view('admin.storages');
		});

		Route::get('information/operating_systems',function(){
			return view('admin.opoperating_systems');
		});

		Route::get('/brands',function(){
			return view('admin.brands');
		});

		Route::get('/products',function(){
			return view('admin.products');
		});

		
		Route::get('/orders',function(){
			return view('admin.orders');
		});

		Route::get('/orderdetails',function(){
			return view('admin.orderdetails');
		});

		Route::get('/users',function(){
			return view('admin.users');
		});

		Route::get('/comments',function(){
			return view('admin.comments');
		});

		Route::get('/images',function(){
			return view('admin.images');
		});

		Route::get('/exs',function(){
			return view('admin.exs');
		});
		// ==================chart==================
		Route::get('/chartteam',function(){
			$info=[];
				for($i=12;$i>=0;$i--){
					$date = date("m/d/Y",time()-2629743*$i);	
					$arrayDate = explode('/',$date);
					$count = DB::table('orders')
					->whereYear('created_at', $arrayDate[2])
					->whereMonth('created_at',$arrayDate[0])
					->count();
					// $info[$arrayDate[2].'-'.$arrayDate[0]]=$count;
					$info['y'][]=$arrayDate[2].'-'.$arrayDate[0];
					$info['a'][]=$count;
				}
				return $info;
		});

		Route::get('/bar',function(){
			$info=[];
				for($i=6;$i>=0;$i--){
					$date = date("m/d/Y",time()-2629743*$i);	
					$arrayDate = explode('/',$date);
					$count = DB::table('users')
					->whereYear('created_at', $arrayDate[2])
					->whereMonth('created_at',$arrayDate[0])
					->count();
					// $info[$arrayDate[2].'-'.$arrayDate[0]]=$count;
					$info['y'][]=$arrayDate[2].'-'.$arrayDate[0];
					$info['a'][]=$count;
				}
				return $info;
		});


		Route::get('/haizz',function(){
			$info=[];
				for($i=6;$i>=0;$i--){
					$date = date("m/d/Y",time()-2629743*$i);	
					$arrayDate = explode('/',$date);
					$count = DB::table('comments')
					->whereYear('created_at', $arrayDate[2])
					->whereMonth('created_at',$arrayDate[0])
					->count();
					// $info[$arrayDate[2].'-'.$arrayDate[0]]=$count;
					$info['y'][]=$arrayDate[2].'-'.$arrayDate[0];
					$info['a'][]=$count;
				}
				return $info;
		});


		Route::get('/product-pie',function(){
			$info=[];
			$brand = DB::table('brands')
					->select('id','name')
					->get();
			foreach ($brand as $value) {
				$info['y'][] = $value->name;
				$info['a'][] = Product::where('brand_id',$value->id)->count();
			}
			return $info;
		});

		// =========================================

		// colors
		Route::post('color','AdminController@color');

		Route::get('color_information','AdminController@colorInformation');

		Route::post('color_edit','AdminController@colorEdit');

		Route::post('color_delete','AdminController@colorDelete');
		// end colors

		// displays
		Route::post('display','AdminController@display');

		Route::get('display_information','AdminController@displayInformation');

		Route::post('display_edit','AdminController@displayEdit');

		Route::post('display_delete','AdminController@displayDelete');
		// end displays

		// stogares
		Route::post('storage','AdminController@storage');

		Route::get('storage_information','AdminController@storageInformation');

		Route::post('storage_edit','AdminController@storageEdit');

		Route::post('storage_delete','AdminController@storageDelete');
		// end stogares

		// opoperating_system
		Route::post('opoperating_systems','AdminController@opoperating_system');

		Route::get('opoperating_systems_information','AdminController@opoperating_systemInformation');

		Route::post('opoperating_systems_edit','AdminController@opoperating_systemEdit');

		Route::post('opoperating_systems_delete','AdminController@opoperating_systemDelete');
		// end opoperating_system

		// brand
		Route::post('brand','AdminController@brand');

		Route::get('brand_information','AdminController@brandInformation');

		Route::post('brand_edit','AdminController@brandEdit');

		Route::post('brand_delete','AdminController@brandDelete');
		// end brand

		// product
		Route::post('product','AdminController@product');

		Route::get('product_information','AdminController@productInformation');

		Route::post('product_edit','AdminController@productEdit');

		Route::post('product_delete','AdminController@productDelete');
		// end product

		// order
		Route::post('order','AdminController@order');

		Route::get('order_information','AdminController@orderInformation');

		Route::post('order_edit','AdminController@orderEdit');

		Route::post('order_delete','AdminController@orderDelete');
		// end order

		// orderdetail
		Route::post('orderdetail','AdminController@orderdetail');

		Route::get('orderdetail_information','AdminController@orderdetailInformation');

		Route::post('orderdetail_edit','AdminController@orderdetailEdit');

		Route::post('orderdetail_delete','AdminController@orderdetailDelete');
		// end orderdetail

		// user
		Route::post('user','AdminController@user');

		Route::get('user_information','AdminController@userInformation');

		Route::post('user_edit','AdminController@userEdit');

		Route::post('user_delete','AdminController@userDelete');
		// user

		// comment
		// Route::post('comment','AdminController@comment');

		Route::get('comment_information','AdminController@commentInformation');

		// Route::post('comment_edit','AdminController@commentEdit');

		Route::post('comment_delete','AdminController@commentDelete');
		// comment


		// image
		// Route::post('user','AdminController@user');

		Route::get('image_information','AdminController@imageInformation');

		Route::post('user_edit','AdminController@userEdit');

		Route::post('user_delete','AdminController@userDelete');
		// image

		// mở rộng
		Route::post('ex','AdminController@ex');

		Route::get('ex_information','AdminController@exInformation');

		Route::post('ex_edit','AdminController@exEdit');

		Route::post('ex_delete','AdminController@exDelete');
		// end mở rộng


	}
	
	
);