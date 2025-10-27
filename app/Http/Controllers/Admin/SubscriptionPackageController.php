<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Model\Cost;
use App\CPU\Convert;
use App\CPU\Helpers;
use App\Models\User;
use App\Model\Category;
use Carbon\CarbonPeriod;
use App\CPU\BackEndHelper;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Model\BusinessSetting;
use App\Model\SponsoredAdType;
use App\Model\WithdrawRequest;
use App\Model\SubscriptionPackage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use App\Model\SubscriptionPackageFeature;


class SubscriptionPackageController extends Controller
{

    public function list(Request $request)
    {
        $packages = SubscriptionPackage::with('type')->get();
        return view('admin-views.subscription-packages.list', compact('packages'));
    }
    
    public function add_new()
    {
        $sponsor_types = SponsoredAdType::get();
        return view('admin-views.subscription-packages.add-new', compact('sponsor_types'));
    }

    public function store(Request $request) {

        $request->validate([
            'subscription_type' => 'required',
            'price' => 'required|numeric',
            'duration_in_days' => 'required|numeric',
        ]);

        $package = new SubscriptionPackage;
        $package->price = $request->price;
        $package->duration_in_days = $request->duration_in_days;
        $package->type_id = $request->subscription_type;
        
        $package->save();

        Cache::forget('subscription_packages');

        Toastr::success(translate('package_added_successfully'));
        return redirect()->route('admin.subscription.packages.list');
    }

    public function edit($id)
    {
        $package = SubscriptionPackage::findOrFail($id);
        $sponsor_types = SponsoredAdType::get();

        return view('admin-views.subscription-packages.edit', compact('package', 'sponsor_types'));
    }
    
    public function update(Request $request) {
    
        $request->validate([
            'subscription_type' => 'required',
            'price' => 'required|numeric',
            'duration_in_days' => 'required|numeric',
        ]);

        $package = SubscriptionPackage::findOrFail($request->id);

        $package->price = $request->price;
        $package->duration_in_days = $request->duration_in_days;

        if($request->subscription_type != $package->type_id) {
            $package->type_id = $request->subscription_type;
            $package->features()->detach();
        }

        $package->save();

        Cache::forget('subscription_packages');

        Toastr::success(translate('package_updated_successfully'));
        return redirect()->route('admin.subscription.packages.list');
    }

    public function status_update(Request $request)
    {

        $package = SubscriptionPackage::find($request['id']);
        $package->status = $request['status'] ? 0 : 1;

        if($package->save()){
            $success = 1;
        }else{
            $success = 0;
        }

        Cache::forget('subscription_packages');
        Cache::forget('adding_subscription_packages');
        Cache::flush();

        return response()->json([
            'success' => $success,
        ], 200);
    }

    public function features_view($id) {
        $package = SubscriptionPackage::with('features')->findOrFail($id);
        
        $features = SubscriptionPackageFeature::where('type_id', $package->type_id)->get();

        Cache::forget('subscription_packages');
        Cache::forget('adding_subscription_packages');
        Cache::flush();

        return view('admin-views.subscription-packages.features.add-remove-package-features', compact('package', 'features'));
    }

    public function features(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:subscription_packages,id',
            'features'   => 'array',
            'features.*' => 'exists:subscription_package_features,id',
        ]);

        $package = SubscriptionPackage::findOrFail($request->package_id);

        // This will attach new features and detach unchecked ones
        $package->features()->sync($request->features ?? []);

        Cache::forget('subscription_packages');
        Cache::forget('adding_subscription_packages');
        Cache::flush();

        Toastr::success(translate('package_features_updated_successfully'));
        return redirect()->route('admin.subscription.packages.list');
    }

    public function delete(Request $request)
    {
        $package = SubscriptionPackage::find($request->id);
        $package->delete();

        Cache::forget('subscription_packages');
        Cache::forget('adding_subscription_packages');
        Cache::flush();

        return response()->json();
    }


}







