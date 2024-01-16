<?php

use App\Http\Controllers\Admin\AdminBannerController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminCommentController;
use App\Http\Controllers\Admin\AdminFaqController;
use App\Http\Controllers\Admin\AdminFaqItemController;
use App\Http\Controllers\Admin\AdminMerchant\AdminMerchantBannerController;
use App\Http\Controllers\Admin\AdminMerchant\AdminMerchantCategoryController;
use App\Http\Controllers\Admin\AdminMerchant\AdminMerchantCommentController;
use App\Http\Controllers\Admin\AdminMerchant\AdminMerchantFaqController;
use App\Http\Controllers\Admin\AdminMerchant\AdminMerchantFaqItemController;
use App\Http\Controllers\Admin\AdminMerchant\AdminMerchantPageController;
use App\Http\Controllers\Admin\AdminMerchant\AdminMerchantPostController;
use App\Http\Controllers\Admin\AdminMerchant\AdminMerchantSettingController;
use App\Http\Controllers\Admin\AdminMerchant\AdminMerchantSliderController;
use App\Http\Controllers\Admin\AdminMerchant\AdminMerchantTagController;
use App\Http\Controllers\Admin\AdminMerchant\AdminMerchantTextController;
use App\Http\Controllers\Admin\AdminPageController;
use App\Http\Controllers\Admin\AdminPostController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\AdminSliderController;
use App\Http\Controllers\Admin\AdminTagController;
use App\Http\Controllers\Admin\AdminTextController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\Merchant\MerchantBannerController;
use App\Http\Controllers\Merchant\MerchantCategoryController;
use App\Http\Controllers\Merchant\MerchantCommentController;
use App\Http\Controllers\Merchant\MerchantFaqController;
use App\Http\Controllers\Merchant\MerchantPostController;
use App\Http\Controllers\Merchant\MerchantSliderController;
use App\Http\Controllers\Merchant\MerchantTagController;
use App\Http\Controllers\Merchant\MerchantTextController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TextController;
use Illuminate\Support\Facades\Route;

//magazine Prefix
Route::prefix('magazine')->group(function () {

    // Post
    Route::get('post/{id}', [PostController::class, 'show']);

    // Sorted Post
    Route::get('post/sort/{id}', [PostController::class, 'sort']);

    // Post Share Count
    Route::post('post/{id}/share', [PostController::class, 'share']);

    // Banner
    Route::get('banner', [BannerController::class, 'index']);

    // Slider
    Route::get('slider', [SliderController::class, 'index']);

    // Category
    Route::get('category/{id}', [CategoryController::class, 'show']);

    // Tag
    Route::get('tag/{id}', [TagController::class, 'show']);

    // Text
    Route::get('text', [TextController::class, 'show']);

    // Faq
    Route::get('faq', [FaqController::class, 'index']);

    // Sort Comment
    Route::get('comment/sort/{id}', [CommentController::class, 'sort']);


    /**--------------------------- Merchant --------------------------- */

    Route::prefix('merchant')->group(function () {

        // Merchant Bookmark Post
        Route::post('post/bookmark/{id}', [MerchantPostController::class, 'addBookmark']);

        // Merchant Favorite Post
        Route::post('post/favorite/{id}', [MerchantPostController::class, 'addFavorite']);

        // Merchant Latest Post
        Route::get('post/latest', [MerchantPostController::class, 'latest']);


        // Merchant Sorted Post
        Route::get('post/sort/{id}', [MerchantPostController::class, 'sort']);

        // Merchant Post Share Count
        Route::post('post/share/{id}', [MerchantPostController::class, 'share']);

        // Merchant Post
        Route::get('post/{id}', [MerchantPostController::class, 'show']);

        // Merchant Banner
        Route::get('banner', [MerchantBannerController::class, 'index']);

        // Merchant Slider
        Route::get('slider', [MerchantSliderController::class, 'index']);

        // Merchant Category
        Route::get('category/{id}', [MerchantCategoryController::class, 'show']);

        // Merchant Tag
        Route::get('tag/{id}', [MerchantTagController::class, 'show']);

        // Merchant Text
        Route::get('text', [MerchantTextController::class, 'show']);

        // Merchant Faq
        Route::get('faq', [MerchantFaqController::class, 'index']);

        // Merchant Sort Comment
        Route::get('comment/sort/{id}', [MerchantCommentController::class, 'sort']);
    });

    /**--------------------------- Admin --------------------------- */

    // Admin Post
    Route::controller(AdminPostController::class)->group(function () {
        Route::post('admin/post', 'store');
        Route::get('admin/post', 'index');
        Route::put('admin/post/{id}', 'update');
        Route::post('admin/post/delete', 'delete');

    });

    // Admin Tag
    Route::controller(AdminTagController::class)->group(function () {
        Route::get('admin/tag', 'index');
        Route::post('admin/tag', 'store');
        Route::put('admin/tag/{id}', 'update');
        Route::post('admin/tag/delete', 'delete');
    });

    // Admin Category
    Route::controller(AdminCategoryController::class)->group(function () {
        Route::get('admin/category', 'index');
        Route::post('admin/category', 'store');
        Route::get('admin/category/{slug}', 'show');
        Route::put('admin/category/{id}', 'update');
        Route::post('admin/category/delete', 'delete');
    });

    // Admin Comment
    Route::controller(AdminCommentController::class)->group(function () {
        Route::get('admin/comments', 'index');
        Route::post('admin/comments', 'store');
        Route::put('admin/comments/{id}', 'update');
        Route::post('admin/comments/delete', 'delete');
        Route::post('admin/comments/{id}/like', 'like');
        Route::post('admin/comments/{id}/dislike', 'dislike');
    });

    // Admin Setting
    Route::controller(AdminSettingController::class)->group(function () {
        Route::get('admin/setting', 'index');
        Route::post('admin/setting', 'store');
        Route::put('admin/setting/{id}', 'update');
    });

    // Admin Slider
    Route::controller(AdminSliderController::class)->group(function () {
        Route::get('admin/slider', 'index');
        Route::post('admin/slider', 'store');
        Route::put('admin/slider/{id}', 'update');
        Route::post('admin/slider/delete', 'delete');
    });

    // Admin Banner
    Route::controller(AdminBannerController::class)->group(function () {
        Route::get('admin/banner', 'index');
        Route::post('admin/banner', 'store');
        Route::put('admin/banner/{id}', 'update');
        Route::post('admin/banner/delete', 'delete');
    });

    // Admin Page
    Route::controller(AdminPageController::class)->group(function () {
        Route::get('admin/page', 'index');
        Route::post('admin/page', 'store');
        Route::put('admin/page/{id}', 'update');
        Route::post('admin/page/delete', 'delete');
    });

    // Admin Faq
    Route::controller(AdminFaqController::class)->group(function () {
        Route::get('admin/faq', 'index');
        Route::post('admin/faq', 'store');
        Route::put('admin/faq/{id}', 'update');
        Route::post('admin/faq/delete', 'delete');
    });

    // Admin Faq Item
    Route::controller(AdminFaqItemController::class)->group(function () {
        Route::get('admin/faq/item', 'index');
        Route::post('admin/faq/item', 'store');
        Route::put('admin/faq/item/{id}', 'update');
        Route::post('admin/faq/item/delete', 'delete');
    });

    // Admin Texts
    Route::controller(AdminTextController::class)->group(function () {
        Route::get('admin/text', 'index');
        Route::post('admin/text', 'store');
        Route::put('admin/text/{id}', 'update');
        Route::post('admin/text/delete', 'delete');
    });

    /**----------------------------------AdminMerchant----------------------------------*/

    Route::prefix('/admin/merchant/')->group(function () {

        // Admin Merchant Banner
        Route::prefix('banner')->controller(AdminMerchantBannerController::class)->group(function () {
            Route::get('', 'index');
            Route::post('', 'store');
            Route::put('/{id}', 'update');
            Route::post('/delete', 'delete');
        });

        // Admin Merchant Category
        Route::prefix('category')->controller(AdminMerchantCategoryController::class)->group(function () {
            Route::get('', 'index');
            Route::post('', 'store');
            Route::put('/{id}', 'update');
            Route::post('/delete', 'delete');
        });

        // Admin Merchant  Tag
        Route::prefix('tag')->controller(AdminMerchantTagController::class)->group(function () {
            Route::get('', 'index');
            Route::post('', 'store');
            Route::put('/{id}', 'update');
            Route::post('/delete', 'delete');
        });

        // Admin Merchant Post
        Route::prefix('post')->controller(AdminMerchantPostController::class)->group(function () {
            Route::get('', 'index');
            Route::post('', 'store');
            Route::put('/{id}', 'update');
            Route::post('/delete', 'delete');
        });

        // Admin Merchant Comment
        Route::prefix('/comment')->controller(AdminMerchantCommentController::class)->group(function () {
            Route::get('', 'index');
            Route::post('', 'store');
            Route::put('/{id}', 'update');
            Route::post('/delete', 'delete');
            Route::post('/like', 'like');
            Route::post('/dislike', 'dislike');
        });

        // Admin Merchant Faq
        Route::prefix('faq')->controller(AdminMerchantFaqController::class)->group(function () {
            Route::get('', 'index');
            Route::post('', 'store');
            Route::put('/{id}', 'update');
            Route::post('/delete', 'delete');
        });

        // Admin Merchant Faq Item
        Route::prefix('faq/item')->controller(AdminMerchantFaqItemController::class)->group(function () {
            Route::get('', 'index');
            Route::post('', 'store');
            Route::put('/{id}', 'update');
            Route::post('/delete', 'delete');
        });

        // Admin Merchant Page
        Route::prefix('page')->controller(AdminMerchantPageController::class)->group(function () {
            Route::get('', 'index');
            Route::post('', 'store');
            Route::put('/{id}', 'update');
            Route::post('/delete', 'delete');
        });

        // Admin Merchant Setting
        Route::prefix('setting')->controller(AdminMerchantSettingController::class)->group(function () {
            Route::get('', 'index');
            Route::put('{id}', 'update');
        });

        // Admin Merchant Slider
        Route::prefix('slider')->controller(AdminMerchantSliderController::class)->group(function () {
            Route::get('', 'index');
            Route::post('', 'store');
            Route::put('/{id}', 'update');
            Route::post('/delete', 'delete');
        });

        // Admin Merchant Text
        Route::prefix('text')->controller(AdminMerchantTextController::class)->group(function () {
            Route::get('', 'index');
            Route::post('', 'store');
            Route::put('/{id}', 'update');
            Route::post('/delete', 'delete');
        });
    });
});
