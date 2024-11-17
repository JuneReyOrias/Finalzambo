<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KmlFileController;
use App\Http\Controllers\Backend\PersonalInformationsController;
use App\Http\Controllers\Backend\FixedCostController;
use App\Http\Controllers\Backend\FarmProfileController;
use App\Http\Controllers\Backend\FertilizerController;
use App\Http\Controllers\Backend\LaborController;
use App\Http\Controllers\Backend\LastProductionDataController;
use App\Http\Controllers\Backend\MachineriesUsedController;
use App\Http\Controllers\Backend\PesticideController;
use App\Http\Controllers\Backend\SeedController;
use App\Http\Controllers\Backend\TransportController;
use App\Http\Controllers\Backend\VariableCostController;
use App\Http\Controllers\boarders\ParcelBoarderController;
use App\Http\Controllers\category\AgriDistrictController;
use App\Http\Controllers\category\CategorizeController;
use App\Http\Controllers\category\CropCategoryController;
use App\Http\Controllers\category\CropController;
use App\Http\Controllers\category\FisheriesCategoryController;
use App\Http\Controllers\category\FisheriesController;
use App\Http\Controllers\category\LivestockCategoryController;
use App\Http\Controllers\category\LivestockController;
use App\Http\Controllers\category\PolygonController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\KmlImportController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\UserAccountController;
use App\Models\AgriDistrict;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// Route::get('home/', function () {
//     return view('home');
// });

// Route::get('dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard'); 

Route::get('dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified',])->name('dashboard');
// Protected route with auth middleware

// Route::get('/dashboard', function () {
//     if (Auth::check()) {
//         return view('dashboard'); // User is authenticated, show dashboard
//     }

//     return redirect()->route('login')->with('error', 'Please log in to access the dashboard.'); // Redirect to login if not authenticated
// });
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');


Route::get('/notifications', [NotificationController::class, 'index']);
Route::post('/notifications/clear', [NotificationController::class, 'clearNotifications']);
Route::get('/agent-import-multipleFile', [FileController::class, 'downloadTemplate']);

    // fetching the users
    Route::get('/get-users', [AgentController::class, 'getUsers']);
    Route::post('/update-farm-profile', [AgentController::class, 'updateFarmProfile']);
    Route::post('/admin-update-farm-profile', [AdminController::class, 'updateCropLocation']);
    // multiple delete Production data, Fixed Costs, Machineries COst, Variable Cost, Solds
    Route::post('admin-view-Farmers-productions/delete', [AdminController::class, 'multipleDelete']);
    Route::post('/admin-multiFixedcost', [AdminController::class, 'multipleDeleteFixedCost']);
    Route::post('/admin-multiMachineries', [AdminController::class, 'multipleDeleteMachineries']);
    Route::post('/admin-multiVariablecost', [AdminController::class, 'multipleDeleteVariablecost']);
    Route::post('/admin-multiSoldcost', [AdminController::class, 'multipleDeleteSoldscost']);
    Route::post('/admin-multiSoldcost', [AdminController::class, 'multipleDeleteSoldscost']);
    // farmer profiling
    Route::get('/user-farmer-Profiling',[FarmProfileController::class, 'FarmerProfiling'])->name('user.farmerInfo.profilingData');

    // LANDING PAGE FETCH DATA
    Route::get('/farmer-profile-data',[LandingPageController::class, 'FarmersProfile']);
    Route::get('/landing-page-data',[LandingPageController::class, 'fetchData']);
    Route::get('/About-Us',[LandingPageController::class, 'AboutUs']);
    Route::get('/Contact-Us',[LandingPageController::class, 'ContactUs']);

// agent accent all farners
Route::post('/admin-view-polygon',[adminController ::class,'store']);

Route::get('/admin-edit-polygon/{polygon}',[PolygonController::class, 'polygonEdit'])->name('polygon.polygons_edit');
Route::post('/admin-edit-polygon/{polygon}',[PolygonController::class, 'update']);
Route::delete('/admin-delete-polygon/{polygon}',[PolygonController::class, 'polygondelete'])->name('polygon.delete');
// agent accent all farners
Route::get('/agent-view-farmers',[AgentController ::class,'ViewFarmers'])->name('agent.FarmerInfo.farmers_view');
Route::get('/agent-edit-farmers/{personalinfos}',[AgentController ::class,'FarmersInfoEdit'])->name('agent.FarmerInfo.crudfarmer.edit');
Route::post('/agent-edit-farmers/{personalinfos}',[AgentController ::class,'StoreFarmers']);
Route::post('/agent-delete-farmers/{personalinfos}',[AgentController ::class,'DeleteFarmers'])->name('agent.FarmerInfo.crudfarmer.delete');

// farms access
Route::get('/agent-view-farms/{personalinfos}',[AgentController ::class,'Viewfarms'])->name('agent.FarmerInfo.farm_view');
Route::get('/agent-add-farms/{personalinfos}',[AgentController ::class,'NewAddFarms'])->name('agent.FarmInfo.crudFarm.add');
Route::post('/agent-add-farms/{personalinfos}',[AgentController ::class,'StoreNewFarms']);
Route::get('/agent-edit-farms/{personalinfos}',[AgentController ::class,'ViewEditFarms'])->name('agent.FarmInfo.crudFarm.edit');
Route::post('/agent-edit-farms/{personalinfos}',[AgentController ::class,'EditFarms']);
Route::Delete('/agent-delete-farms/{personalinfos}',[AgentController ::class,'DeleteFarm'])->name('agent.FarmInfo.crudFarm.delete');

// agent access Farmer-Crops
Route::get('/agent-view-farmer-crops/{farmData}',[AgentController ::class,'ViewFarmerCrops'])->name('agent.FarmerInfo.crops_view');
Route::get('/agent-add-farmer-crops/{farmData}',[AgentController ::class,'ViewAddCrops'])->name('agent.FarmerInfo.CrudCrop.add');
Route::post('/agent-add-farmer-crops/{farmData}',[AgentController ::class,'SaveNewCrop']);
Route::get('/agent-edit-farmer-crops/{farmData}',[AgentController ::class,'EditCrops'])->name('agent.FarmerInfo.CrudCrop.edit');
Route::post('/agent-edit-farmer-crops/{farmData}',[AgentController ::class,'UpdatedCrop']);
Route::delete('/agent-delete-farmer-crops/{farmData}',[AgentController ::class,'DeletingCrops'])->name('agent.FarmerInfo.CrudCrop.delete');

// agent access Production Crop
Route::get('/agent-view-farmer-production/{cropData}',[AgentController ::class,'FarmerProduction'])->name('agent.FarmerInfo.production_view');
Route::get('/agent-add-farmer-production/{cropData}',[AgentController ::class,'viewCropProduction'])->name('agent.FarmerInfo.product.new_data');
Route::post('/agent-add-farmer-production/{cropData}',[AgentController ::class,'storeProduction']);
Route::get('/agent-edit-farmer-production/{cropData}',[AgentController ::class,'EditProductionCrops'])->name('agent.FarmerInfo.product.edit');
Route::post('/agent-edit-farmer-production/{cropData}',[AgentController ::class,'UpdatedProduction']);
Route::delete('/agent-delete-farmer-production/{cropData}',[AgentController ::class,'DeleteProduction'])->name('agent.FarmerInfo.product.delete');


//  AGENT ACCESS fIX COST CROP
Route::get('/agent-add-farmer-fixed-cost/{cropData}',[AgentController ::class,'viewFixedCost'])->name('agent.FarmerInfo.fixed.add_view');
Route::post('/agent-add-farmer-fixed-cost/{cropData}',[AgentController ::class,'storeFixedCost']);
Route::get('/agent-edit-farmer-fixed-cost/{cropData}',[AgentController ::class,'EditFixedCost'])->name('agent.FarmerInfo.fixed.edit_view');
Route::post('/agent-edit-farmer-fixed-cost/{cropData}',[AgentController ::class,'UpdatedFixedCost']);
Route::delete('/agent-delete-farmer-fixed-cost/{cropData}',[AgentController ::class,'DeleteFixedCost'])->name('agent.FarmerInfo.fixed.delete');

// agent access machineries
Route::get('/agent-edit-farmer-machineries-cost/{cropData}',[AgentController ::class,'EditMachine'])->name('agent.FarmerInfo.machineries.edit_view');
Route::post('/agent-edit-farmer-machineries-cost/{cropData}',[AgentController ::class,'UpdateMachine']);
Route::delete('/agent-delete-farmer-machineries-cost/{cropData}',[AgentController ::class,'Delete'])->name('agent.FarmerInfo.machineries.delete');

// agent access variable
Route::get('/agent-edit-farmer-variable-cost/{cropData}',[AgentController ::class,'EditVariable'])->name('agent.FarmerInfo.variable.edit');
Route::post('/agent-edit-farmer-variable-cost/{cropData}',[AgentController ::class,'UpdateVariable']);
Route::delete('/agent-delete-farmer-variable-cost/{cropData}',[AgentController ::class,'DeleteVariable'])->name('agent.FarmerInfo.variable.delete');

// agent access Solds
Route::get('/agent-add-farmer-Production-sold/{cropData}',[AgentController ::class,'AddSolds'])->name('agent.FarmerInfo.Solds.add');
Route::post('/agent-add-farmer-Production-sold/{cropData}',[AgentController ::class,'StoreSolds']);
Route::get('/agent-edit-farmer-Production-sold/{cropData}',[AgentController ::class,'EditSolds'])->name('agent.FarmerInfo.Solds.edit');
Route::post('/agent-edit-farmer-Production-sold/{cropData}',[AgentController ::class,'UpdateSolds']);
Route::delete('/agent-delete-farmer-Production-sold/{cropData}',[AgentController ::class,'DeleteSolds'])->name('agent.FarmerInfo.Solds.delete');

//agent access farmer Survey form
Route::get('/agent-crops-survey-form',[AgentController ::class,'ViewSurveyForm'])->name('agent.SurveyForm.new_farmer');
Route::post('/agent-crops-survey-form',[AgentController ::class,'AgentSurveyForm']);

//agent access all  cropsreport
Route::get('/agent-all-crops-report',[AgentController ::class,'AgentAllCrops'])->name('agent.CropReport.all_crops');

// admin access all  cropsreport
Route::get('/admin-all-crops-report',[FarmProfileController ::class,'AllCrops'])->name('admin.cropsreport.all_crops');

// Crop Variety
Route::get('/admin-add-crop-variety',[PolygonController ::class,'AddVariety'])->name('admin.variety.add_variety');
Route::post('/admin-add-crop-variety',[PolygonController ::class,'SaveVariety']);
Route::get('/admin-edit-crop-variety/{variety}',[PolygonController ::class,'editVariety'])->name('admin.variety.edit_variety');
Route::post('/admin-edit-crop-variety/{variety}',[PolygonController ::class,'UpdateVariety']);
Route::post('/admin-delete-crop-variety/{variety}',[PolygonController ::class,'DeleteVariety'])->name('admin.variety.delete');

// view crop
Route::get('/admin-add-crop-farms/{farmData}',[FarmProfileController ::class,'cropsnewfarm'])->name('admin.farmersdata.cropsdata.add_crop');
Route::post('/admin-add-crop-farms/{farmData}',[FarmProfileController ::class,'saveCropfarm']);
Route::get('/admin-edit-crop-farms/{farmData}',[FarmProfileController ::class,'CropEdit'])->name('admin.farmersdata.cropsdata.edit_crops');
Route::post('/admin-edit-crop-farms/{farmData}',[FarmProfileController ::class,'Updatecrop']);
Route::get('/admin-delete-crop-farms/{farmData}',[FarmProfileController ::class,'Deletecropfarm'])->name('admin.farmersdata.cropsdata.delete');

// view admin survey
Route::get('/admin-view-Farmers-survey-form',[PersonalInformationsController ::class,'samplefolder'])->name('admin.farmersdata.samplefolder.farm_edit');
Route::post('/admin-view-Farmers-survey-form',[PersonalInformationsController ::class,'test']);

// routes/web.php
Route::post('/check-farmer-existence', [PersonalInformationsController::class, 'checkFarmerExistence']);
Route::post('/check-cropping-no', [PersonalInformationsController::class, 'checkCroppingNo']);


// Route::get('/admin-edit-crop-farms/{farmData}',[FarmProfileController ::class,'CropEdit'])->name('admin.farmersdata.cropsdata.delete');



// admin view production
Route::get('/admin-view-Farmers-productions/{cropData}',[PersonalInformationsController ::class,'productionview'])->name('admin.farmersdata.production');
Route::get('/admin-add-Farmers-productions/{cropData}',[PersonalInformationsController ::class,'productionAdd'])->name('admin.farmersdata.crudProduction.add');
Route::post('/admin-add-Farmers-productions/{cropData}',[PersonalInformationsController ::class,'productionSave']);
Route::get('/admin-edit-Farmers-productions/{cropData}',[PersonalInformationsController ::class,'productionEdit'])->name('admin.farmersdata.crudProduction.edit');
Route::post('/admin-edit-Farmers-productions/{cropData}',[PersonalInformationsController ::class,'productionUpdate']);
Route::delete('/admin-delete-Farmers-productions/{cropData}',[PersonalInformationsController ::class,'productiondelete'])->name('admin.farmersdata.crudProduction.delete');

// admin fixed cost
Route::get('/admin-add-Farmers-fixedCost/{cropData}',[PersonalInformationsController ::class,'fixedAdd'])->name('admin.farmersdata.CrudFixed.add');
Route::post('/admin-add-Farmers-fixedCost/{cropData}',[PersonalInformationsController ::class,'fixedSave']);
Route::get('/admin-edit-Farmers-fixedCost/{cropData}',[PersonalInformationsController ::class,'fixedEdit'])->name('admin.farmersdata.CrudFixed.edit');
Route::post('/admin-edit-Farmers-fixedCost/{cropData}',[PersonalInformationsController ::class,'fixedUpdate']);
Route::delete('/admin-delete-Farmers-fixedCost/{cropData}',[PersonalInformationsController ::class,'fixeddelete'])->name('admin.farmersdata.CrudFixed.delete');


// admin machineries
Route::get('/admin-add-Farmers-Machineries-Cost/{cropData}',[PersonalInformationsController ::class,'AddMachinerie'])->name('admin.farmersdata.CrudMachineries.add');
Route::post('/admin-add-Farmers-Machineries-Cost/{cropData}',[PersonalInformationsController ::class,'MachineriesSave']);
Route::get('/admin-edit-Farmers-Machineries-Cost/{cropData}',[PersonalInformationsController ::class,'MachineriesEdit'])->name('admin.farmersdata.CrudMachineries.edit');
Route::post('/admin-edit-Farmers-Machineries-Cost/{cropData}',[PersonalInformationsController ::class,'MachineriesUpdate']);
Route::delete('/admin-delete-Farmers-Machineries-Cost/{cropData}',[PersonalInformationsController ::class,'Machineriesdelete'])->name('admin.farmersdata.CrudMachineries.delete');

// admin variables 

Route::get('/admin-add-Farmers-Variable-Cost/{cropData}',[PersonalInformationsController ::class,'AddVariable'])->name('admin.farmersdata.CrudVariable.add');
Route::post('/admin-add-Farmers-Variable-Cost/{cropData}',[PersonalInformationsController ::class,'VariableSave']);
Route::get('/admin-edit-Farmers-Variable-Cost/{cropData}',[PersonalInformationsController ::class,'VariableEdit'])->name('admin.farmersdata.CrudVariable.edit');
Route::post('/admin-edit-Farmers-Variable-Cost/{cropData}',[PersonalInformationsController ::class,'VariableUpdate']);
Route::delete('/admin-delete-Farmers-Variable-Cost/{cropData}',[PersonalInformationsController ::class,'Variabledelete'])->name('admin.farmersdata.CrudVariable.delete');

// admin Solds
Route::get('/admin-add-Farmers-Solds-Cost/{cropData}',[PersonalInformationsController ::class,'AddSolds'])->name('admin.farmersdata.CrudSolds.add');
Route::post('/admin-add-Farmers-Solds-Cost/{cropData}',[PersonalInformationsController ::class,'SoldsSave']);
Route::get('/admin-edit-Farmers-Solds-Cost/{cropData}',[PersonalInformationsController ::class,'SoldsEdit'])->name('admin.farmersdata.CrudSolds.edit');
Route::post('/admin-edit-Farmers-Solds-Cost/{cropData}',[PersonalInformationsController ::class,'SoldsUpdate']);
Route::delete('/admin-delete-Farmers-Solds-Cost/{cropData}',[PersonalInformationsController ::class,'Soldsdelete'])->name('admin.farmersdata.CrudSolds.delete');

// view crops
Route::get('/admin-view-Farmers-crop/{farmData}',[PersonalInformationsController ::class,'cropview'])->name('admin.farmersdata.crop');

// view farm
Route::get('/admin-view-Farmers-farm/{personalinfos}',[PersonalInformationsController ::class,'farmview'])->name('admin.farmersdata.farm');
// view farmerse data
Route::get('/admin-view-General-Farmers',[AdminController::class,'GenFarmers'])->name('admin.farmersdata.genfarmers');
 

// admin homepage form
 Route::get('/admin-view-homepage-setting',[LandingPageController::class,'viewHomepages'])->name('landing-page.view_homepage');
 Route::get('/admin-add-homepage',[LandingPageController::class,'addHomepage'])->name('landing-page.add_homepage');
 Route::post('/admin-add-homepage',[LandingPageController::class,'SavePage']);
 Route::get('/admin-edit-homepage/{Page}',[LandingPageController::class,'editHomepage'])->name('landing-page.edit_homepage');
 Route::post('/admin-edit-homepage/{Page}',[LandingPageController::class,'editSave']);
 Route::delete('/admin-delete-homepage/{Page}',[LandingPageController::class,'DeletePage'])->name('landing-page.delete');

//  admin add features
Route::get('/admin-add-features',[LandingPageController::class,'addFeatures'])->name('landing-page.Features.add');
Route::post('/admin-add-features',[LandingPageController::class,'saveFeatures']);
Route::get('/admin-edit-features/{Page}',[LandingPageController::class,'editFeatures'])->name('landing-page.Features.edit');
Route::post('/admin-edit-features/{Page}',[LandingPageController::class,'updateFeatures']);
//  notification
 Route::get('/admin-view-notification',[NotificationController::class,'addnotification'])->name('admin.notification.view_notif');
 Route::get('/admin-add-notification',[NotificationController::class,'Message'])->name('admin.notification.add_notif');
 Route::post('/admin-add-notification',[NotificationController::class,'Messagestore']);
 Route::get('/admin-edit-notification/{message}',[NotificationController::class,'NotifEdit'])->name('admin.notification.edit_notif');
 Route::post('/admin-edit-notification/{message}',[NotificationController::class,'MessageUpdate']);
 Route::delete('/admin-delete-notification/{message}',[NotificationController::class,'DeleteNotif'])->name('admin.notification.delete');

 // admin  add barangay form
 Route::get('/admin-add-farmer-org',[AdminController::class,'addFamerOrg'])->name('admin.farmerOrg.add_form');
 Route::post('/admin-add-farmer-org',[AdminController::class,'saveFarmerOrg']);
 Route::get('/admin-view-farmer-org',[AdminController::class,'viewfarmersOrg'])->name('admin.farmerOrg.view_orgs');
 Route::get('/admin-edit-farmer-org/{farmerOrg}',[AdminController::class,'EditOrg'])->name('admin.farmerOrg.edit_org');
 Route::post('/admin-edit-farmer-org/{farmerOrg}',[AdminController::class,'updateFarmerOrg']);
 Route::delete('/admin-delete-farmer-org/{farmerOrg}',[AdminController::class,'deleteFarmerOrg'])->name('admin.farmerOrg.delete');

    // admin  add barangay form
    Route::get('/admin-add-barangay',[AdminController::class,'barangayForm'])->name('admin.barangay.add_form');
    Route::post('/admin-add-barangay',[AdminController::class,'newBarangay']);
    Route::get('/admin-edit-barangays/{barangay}',[AdminController::class,'EditBrgy'])->name('admin.barangay.edit_barangay');
    Route::post('/admin-edit-barangays/{barangay}',[AdminController::class,'updateBarangay']);
    Route::delete('/admin-delete-barangays/{barangay}',[AdminController::class,'destroy'])->name('admin.barangay.delete');
    Route::get('/admin-view-barangays',[AdminController::class,'viewBaranagay'])->name('admin.barangay.view_forms');


    // Route::middleware(['auth', 'prevent-back-history'])->group(function () {
    //     Route::get('/dashboard', [DashboardController::class, 'index']);
    //     Route::get('/profile', [ProfileController::class, 'index']);
    //     // Add more protected routes here
    // });
        // admin corn map 
        Route::get('/admin-view-corn-map',[AdminController::class,'CornMap'])->name('map.cornmap');

        // admin coconut map 
        Route::get('/admin-view-coconut-map',[AdminController::class,'CoconutMap'])->name('map.coconutmap');

        // admin chicken map 
        Route::get('/admin-view-chicken-map',[AdminController::class,'ChickenMap'])->name('map.chickenmap');

        // admin hogs map 
        Route::get('/admin-view-hogs-map',[AdminController::class,'HogsMap'])->name('map.hogsmap');

       

        // admin reports per district map 
        Route::get('admin-view-reports',[AdminController::class,'ayalaCorn'])->name('admin.corn.districtreport.ayala');

       

        // admin reports per district map 
        Route::get('/admin-survey-forms',[AdminController::class,'CornForm'])->name('admin.corn.forms.corn_form');
        Route::post('/admin-survey-forms',[AdminController::class,'CornSave']);
        Route::get('/admin-views',[AdminController::class,'Getforms'])->name('admin.corn.forms.partials.forms-steps');

       
        // admin farmers district map 
        Route::get('/admin-view-farmer-info',[AdminController::class,'FarmerInformations'])->name('admin.corn.farmersInfo.information');
       
     

            // admin varieties district map 
            Route::get('/admin-view-varieties',[AdminController::class,'Varieties'])->name('admin.corn.variety.varieties');

            
            // admin production district map 
            Route::get('admin-view-production',[AdminController::class,'Productions'])->name('admin.corn.production.reportsproduce');


             // agent corn map 
        Route::get('agent-view-crops-map',[AgentController::class,'CornMap'])->name('agent.agri.cornmap');

        // agent coconut map 
        Route::get('agent-view-coconut-map',[AgentController::class,'CoconutMaps'])->name('agent.agri.coconutmap');

        // agent chicken map 
        Route::get('agent-view-chickens-map',[AgentController::class,'ChickenMap'])->name('agent.agri.chickenmap');

        // agent hogs map 
        Route::get('agent-view-hog-map',[AgentController::class,'HogsMap'])->name('agent.agri.hogsmap');

       

        // agent reports per district map 
        Route::get('agent-view-reports',[AgentController::class,'ayalaCorn'])->name('agent.corn.districtreport.ayala');

       

        // agent reports per district map 
        Route::get('agent-view-forms',[AgentController::class,'CornForm'])->name('agent.corn.forms.corn_form');

       
        // agent farmers district map 
        Route::get('agent-view-farmer-info',[AgentController::class,'FarmerInformations'])->name('agent.corn.farmersInfo.information');
       
     

            // agent varieties district map 
            Route::get('agent-view-varieties',[AgentController::class,'Varieties'])->name('agent.corn.variety.varieties');

            
            // agent production district map 
            Route::get('agent-view-production',[AgentController::class,'Productions'])->name('agent.corn.production.reportsproduce');



        // rice crop production per istrict access by admin
        Route::get('admin-view-rice-crop-production',[AdminController::class,'ProductionperRice'])->name('admin.crop_production.rice_crops');

        // rice varieties per agrDistrict acess by admin
        Route::get('admin-view-rice-varietyper-agridistrict',[AdminController::class,'FarmersRiceVarietyDistrict'])->name('admin.rice_varieties.rice_varietydistrict');

        // Rice crop planting and harvest schedule per district acess by admin
        Route::get('admin-view-rice-plantingschedule',[AdminController::class,'Plantingschedrice'])->name('admin.rice_schedule.rice_planting');
        Route::get('admin-view-rice-harvestschedule',[AdminController::class,'HarvestSchedRices'])->name('admin.rice_schedule.rice_harvest');

    // farmers info view per agri district access by admin
    Route::get('admin-view-ayala-farmers',[AdminController::class,'farmerAyalas'])->name('admin.Agri_district.ayala_farmer');
    Route::get('admin-view-tumaga-farmers',[AdminController::class,'FarmerTumagainfo'])->name('admin.Agri_district.tumaga_farmer');
    Route::get('admin-view-culianan-farmers',[AdminController::class,'FarmerCulianansInfo'])->name('admin.Agri_district.culianan_farmer');
    Route::get('admin-view-manicahan-farmers',[AdminController::class,'FarmerManicahaninfo'])->name('admin.Agri_district.manicahan_farmer');
    Route::get('admin-view-curuan-farmers',[AdminController::class,'FarmercuruanInfo'])->name('admin.Agri_district.curuan_farmer');
    Route::get('admin-view-vitali-farmers',[AdminController::class,'VitaliInfoFarmer'])->name('admin.Agri_district.vitali_farmer');




    // Rice Crop Producttions of farmers per agriDistrict
    Route::get('user-view-rice-crop-production',[UserAccountController::class,'CropRiceProduc'])->name('user.cropProduction.rice_crop');

    // rice varieties per agrDistrict
    Route::get('user-view-rice-varietyper-agridistrict',[UserAccountController::class,'VarietyRiceUsers'])->name('user.RiceVariety.inbred_hybrid');
    
    // Rice crop planting and harvest schedule per district
    Route::get('user-view-rice-plantingschedule',[UserAccountController::class,'RicePlantingSched'])->name('user.riceSchedule.rice_planting');
    Route::get('user-view-rice-harvestschedule',[UserAccountController::class,'RiceHarvestSched'])->name('user.riceSchedule.rice_harvest');





    // route for viewing the farmers info per agriDistrict access by user
    Route::get('user-view-ayala-farmers',[UserAccountController::class,'AyalaUserView'])->name('user.agriFarmers.ayala_farmers');
    Route::get('user-view-tumaga-farmers',[UserAccountController::class,'TumagaUserView'])->name('user.agriFarmers.tumaga_farmers');
    Route::get('user-view-culianan-farmers',[UserAccountController::class,'CuliananUserView'])->name('user.agriFarmers.culianan_farmers');
    Route::get('user-view-manicahan-farmers',[UserAccountController::class,'ManicahanUsersView'])->name('user.agriFarmers.manicahan_farmers');
    Route::get('user-view-curuan-farmers',[UserAccountController::class,'CuruanUsersView'])->name('user.agriFarmers.curuan_farmers');
    Route::get('user-view-vitali-farmers',[UserAccountController::class,'VitaliUserView'])->name('user.agriFarmers.vitali_farmers');


// multiple improf execl file to dataase by  agen
Route::get('/agent-import-multipleFiles',[AgentController::class,'ExcelFile'])->name('agent.mutipleFile.import_excelFile');
Route::post('/agent-import-multipleFiles',[FileController::class,'AgentsaveUploadForm']);


// cropProducions
Route::get('/agent-rice-crop-productions',[AgentController::class,'RiceCrop'])->name('agent.cropProductions.rice_crop');

// rice farmers infromation per districts 
Route::get('/agent-view-ayala-districts-farmers',[AgentController::class, 'AyalaFarmers'])->name('agent.agriDistricts.ayala_farmers');

Route::get('/agent-update-ayalafarmers-personal-info/{id}',[AgentController::class, 'show'])->name('agent.ayala.show_personal_info');



Route::get('/agent-view-tumaga-districts-farmers',[AgentController::class, 'TumagaFarmers'])->name('agent.agriDistricts.tumaga_farmers');
Route::get('/agent-view-culianan-districts-farmers',[AgentController::class, 'CuliananFarmers'])->name('agent.agriDistricts.culianan_farmers');
Route::get('/agent-view-manicahan-districts-farmers',[AgentController::class, 'ManicahanFarmers'])->name('agent.agriDistricts.manicahan_farmers');
Route::get('/agent-view-curuan-districts-farmers',[AgentController::class, 'CuruanFarmers'])->name('agent.agriDistricts.curuan_farmers');
Route::get('/agent-view-vitali-districts-farmers',[AgentController::class, 'VitaliFarmers'])->name('agent.agriDistricts.vitali_farmers');
// Rice harvest and planting schedluel of farmers per districts
Route::get('/agent-view-rice-harvest-schedule',[AgentController::class, 'HarvestSched'])->name('agent.Schedule.harvest');
Route::get('/agent-view-rice-planting-schedule',[AgentController::class, 'PlantingSched'])->name('agent.Schedule.planting');

// rice variety view Inbred and hybrid
Route::get('/agent-view-rice-variety-Inbred',[AgentController::class, 'InbredVariety'])->name('agent.riceVariety.inbred_variety');
Route::get('/agent-view-rice-variety-Hybrid',[AgentController::class, 'HybridVariety'])->name('agent.riceVariety.hybrid_variety');


//agentprofile update and view by agent
Route::get('/agent-profile',[AgentController::class, 'AgentProfile'])->name('agent.profile.agent_profiles');
Route::post('/agent-profile',[AgentController::class, 'Agentupdate']);
  
// userprofile view  and update
Route::get('/user-profile',[UserAccountController::class, 'UserProfile'])->name('user.userprofile.profiles');
Route::post('/user-profile',[UserAccountController::class, 'Userupdate']);
  

// aall data fetch of farmers profile

Route::get('/farmer-profile',[PersonalInformationsController::class,'profileFarmer'])->name('agent.allfarmersinfo.profile');

Route::get('/farmers-info',[PersonalInformationsController::class,'FarmersInfo'])->name('admin.allfarmersdata.farmers_info');

// for user 
Route::get('/user-all-farmers',[PersonalInformationsController::class,'forms'])->name('user.forms_data');

// add variable cost variable by agent
Route::get('/add-variable-cost-vartotal',[AgentController::class, 'variableVartotal'])->name('agent.variablecost.variable_total.add_vartotal');
Route::post('/add-variable-cost-vartotal',[AgentController::class, 'AddNewVartotal']);

//fetching the data Vaible cost total in variable cost
Route::get('/agent-show-variable-cost',[AgentController::class,'displayvar'])->name('agent.variablecost.variable_total.show_var');
Route::delete('/agent-delete-variable-cost/{variable}',[AgentController::class,'vardelete'])->name('agent.variablecost.variable_total.delete'); //deleteing 
Route::get('/agent-update-variable-cost/{variable}',[AgentController::class,'varupdate'])->name('agent.variablecost.variable_total.var_edited');
Route::post('/agent-update-variable-cost/{variable}',[AgentController::class,'updatevaria']);



// add variable cost transport by agent
Route::get('/add-variable-cost-transport',[AgentController::class, 'variableTransport'])->name('agent.variablecost.transport.add_transports');
Route::post('/add-variable-cost-transport',[AgentController::class, 'AddNewTransport']);

// edit and view of transport data by agent
Route::get('/agent-show-variable-cost-transport',[AgentController::class,'TransportDataView'])->name('agent.variablecost.transport.show_ttransportsData');
Route::post('/agent-delete-variable-cost-transport/{transport}',[AgentController::class,'TransportDelete'])->name('agent.variablecost.transport.delete'); //deleteing 
Route::get('/agent-update-variable-cost-transport/{tranports}',[AgentController::class,'TransportUpdate'])->name('agent.variablecost.transport.formsEdit_transportsData');
Route::post('/agent-update-variable-cost-transport/{transports}',[AgentController::class,'TransportDataupdate']);


// add variable cost pesticides by agent
Route::get('/add-variable-cost-pesticides',[AgentController::class, 'variablePesticides'])->name('agent.variablecost.pesticides.add_pesticide');
Route::post('/add-variable-cost-pesticides',[AgentController::class, 'AddNewPesticide']);

// edit and view of pesticides data by agent
Route::get('/agent-show-variable-cost-pesticides',[AgentController::class,'PesticideDataView'])->name('agent.variablecost.pesticides.show_pesticidesData');
Route::post('/agent-delete-variable-cost-pesticides/{pesticides}',[AgentController::class,'PesticideDelete'])->name('agent.variablecost.pesticides.delete'); //deleteing 
Route::get('/agent-update-variable-cost-pesticides/{pesticides}',[AgentController::class,'PesticideUpdate'])->name('agent.variablecost.pesticides.formsEdit_pesticidesData');
Route::post('/agent-update-variable-cost-pesticides/{pesticides}',[AgentController::class,'PesticideDataupdate']);



// add variable cost fertilizers by agent
Route::get('/add-variable-cost-fertilizers',[AgentController::class, 'variableFertilizers'])->name('agent.variablecost.fertilizers.add_fertilizer');
Route::post('/add-variable-cost-fertilizers',[AgentController::class, 'AddNewfertilizers']);

// edit and view of FERTILIZERS data by agent
Route::get('/agent-show-variable-cost-fertilizers',[AgentController::class,'FertilizerDataView'])->name('agent.variablecost.fertilizers.show_fertilizeData');
Route::delete('/agent-delete-variable-cost-fertilizers/{fertilizers}',[AgentController::class,'FertilizerDelete'])->name('agent.variablecost.fertilizers.delete'); //deleteing 
Route::get('/agent-update-variable-cost-fertilizers/{fertilizers}',[AgentController::class,'FertilizerUpdate'])->name('agent.variablecost.fertilizers.formsEdit_fertilizeData');
Route::post('/agent-update-variable-cost-fertilizers/{fertilizers}',[AgentController::class,'FertilizerDataupdate']);



// add variable cost labor by agent
Route::get('/add-variable-cost-labor',[AgentController::class, 'variableLabor'])->name('agent.variablecost.labor.add_labors');
Route::post('/add-variable-cost-labor',[AgentController::class, 'AddNewLabor']);

// edit and view of labors data by agent
Route::get('/agent-show-variable-cost-labor',[AgentController::class,'LaborsDataView'])->name('agent.variablecost.labor.show_laborData');
Route::post('/agent-delete-variable-cost-labor/{labor}',[AgentController::class,'LaborsDelete'])->name('agent.variablecost.labor.delete'); //deleteing 
Route::get('/agent-update-variable-cost-labor/{labors}',[AgentController::class,'LaborUpdate'])->name('agent.variablecost.labor.formEdit_labors');
Route::post('/agent-update-variable-cost-labor/{labors}',[AgentController::class,'LaborDataupdate']);


// add variable cost seed by agent
Route::get('/add-variable-cost-seed',[AgentController::class, 'variableSeed'])->name('agent.variablecost.seed.add_seeds');
Route::post('/add-variable-cost-seed',[AgentController::class, 'AddNewSeeed']);

// edit and view of seed data by agent
Route::get('/agent-show-variable-cost-seed',[AgentController::class,'SeedDataView'])->name('agent.variablecost.seed.show_seeds_data');
Route::delete('/agent-delete-variable-cost-seed/{seeds}',[AgentController::class,'SeedsDelete'])->name('agent.variablecost.seed.delete'); //deleteing 
Route::get('/agent-update-variable-cost-seed/{seeds}',[AgentController::class,'SeedsUpdate'])->name('agent.variablecost.seed.seeds_form_edit');
Route::post('/agent-update-variable-cost-seed/{seeds}',[AgentController::class,'SeedDataupdate']);


// add last production by agent
Route::get('/add-last-production',[AgentController::class, 'LastProduction'])->name('agent.lastproduction.add_production');
Route::post('/add-last-production',[AgentController::class, 'AddNewProduction']);

// add last production
Route::get('/show-last-production',[AgentController::class,'viewProduction'])->name('agent.lastproduction.view_prod');
Route::delete('/agent-delete-last-production/{productions}',[AgentController::class,'ProductionDelete'])->name('agent.lastproduction.delete'); //deleteing 
Route::get('/agent-update-last-production/{production}',[AgentController::class,'produpdate'])->name('agent.lastproduction.last_edit');
Route::post('/agent-update-last-production/{productions}',[AgentController::class,'update']);


// add machineries Used by agent
Route::get('/add-machinereies-used',[AgentController::class, 'machineUsed'])->name('agent.machineused.add_mused');
Route::post('/add-machinereies-used',[AgentController::class, 'AddMused']);

// fetch machineries by agent
Route::get('/show-machinereies-used',[AgentController::class,'showMachine'])->name('agent.machineused.show_maused');
Route::delete('/delete-machinereies-used/{machineries}',[AgentController::class,'machinedelete'])->name('agent.machineused.delete'); //deleteing 
Route::get('/agent-update-machinereies-used/{machineries}',[AgentController::class,'MachineUpdate'])->name('agent.machineused.update_machine');
Route::post('/agent-update-machinereies-used/{machineries}',[AgentController::class,'UpdateMachines']);


// add fixed by agent
Route::get('/add-fixed-cost',[AgentController::class, 'fixedCost'])->name('agent.fixedcost.add_fcost');
Route::post('/add-fixed-cost',[AgentController::class, 'AddFcost']);

// fetching and edit of fixed cost
Route::get('/agent-show-fixed-cost',[AgentController::class,'viewFixed'])->name('agent.fixedcost.fcost_view');
Route::delete('/delete-fixed-cost/{fixedcosts}',[AgentController::class,'fixedcostdelete'])->name('agent.fixedcost.delete'); //deleteing fixed cost data
Route::get('/agent-update-fixed-cost/{fixedcosts}',[AgentController::class,'FixedUpdate'])->name('agent.fixedcost.fixed_updates');
Route::post('/agent-update-fixed-cost/{fixedcosts}',[AgentController::class,'UpdateFixedCost']);


// add farm profile by agent
Route::get('/add-farm-profile',[AgentController::class, 'farmprofiles'])->name('agent.farmprofile.add_profile');
Route::post('/add-farm-profile',[AgentController::class, 'AddFarmProfile']);
Route::get('/agent-view-farmer-profile/{farmProfile}',[ AgentController::class,'showFarmerProfiles'])->name('agent.farmprofile.profile_farmers');


// fetching of data from 3 tables to be inserted in farm profiles
// Route::get('/add-farm-profile',[AgentController::class, 'fetchtables'])->name('agent.farmprofile.add_profile');
Route::get('/agent-show-farm-profile',[AgentController::class,'showfarm'])->name('agent.farmprofile.farm_view');
Route::delete('/agent-delete-farm-profile/{farmProfiles}',[AgentController::class,'farmdelete'])->name('agent.farmprofile.delete');
Route::get('/agent-update-farm-profile/{farmProfiles}',[AgentController::class,'farmUpdate'])->name('agent.farmprofile.farm_update');
Route::post('/agent-update-farm-profile/{farmProfiles}',[AgentController::class,'updatesFarm']);





//add personal informatio by agent
Route::get('/add-personal-info',[AgentController::class, 'addpersonalInfo'])->name('agent.personal_info.add_info');

Route::post('/add-personal-info',[AgentController::class, 'addinfo']);
Route::get('/agent-show-personal-info',[AgentController::class,'viewpersoninfo'])->name('agent.personal_info.view_infor');
Route::post('/agent-personal-info/{personalinfos}',[AgentController::class,'infodelete'])->name('agent.personal_info.delete');
Route::get('/agent-update-personal-info/{personalinfos}',[AgentController::class,'updateview'])->name('agent.personal_info.update_records');
Route::post('/agent-update-personal-info/{personalinfos}',[AgentController::class,'updateinfo']);

//landingg page 
Route::get('/', [LandingPageController::class, 'LandingPage'])->name('landing-page.page');

//kml file upload by admin
Route::get('/admin-kml-import', [KmlFileController::class, 'index'])->name('kml.import');
Route::post('/admin-kml-import',[KmlFileController::class, 'upload']);
//kml import by agent 
Route::get('/agent-kml-import',[KmlFileController::class,'AgentKmlImport'])->name('kml.agent_kml_import');
Route::post('/agent-kml-import',[KmlFileController::class,'uploadkml']);

//parcelaryBoarders
Route::get('/admin-add-parcel',[AdminController::class, 'ParcelBoarders'])->name('parcels.new_parcels');
Route::post('/admin-add-parcel',[AdminController::class, 'Parcel']);
// Route::get('/add-parcel',[AgriDistrictController::class, 'ParcelAgrifetch'])->name('parcels.new_parcels');

// parcellary boarder per farm or lot area of farmers access by admin only
Route::get('/admin-view-parcel-boarders',[AdminController::class, 'Parcelshow'])->name('parcels.show');
Route::get('/admin-edit-parcel-boarders/{parcels}',[AdminController::class, 'ParcelEdit'])->name('parcels.edit');
Route::post('/admin-edit-parcel-boarders/{parcels}',[AdminController::class, 'ParcelUpdates']);
Route::post('/admin-delete-parcel-boarders/{parcels}',[AdminController::class, 'Parceldelete'])->name('parcels.delete');


//polygons
Route::get('/admin-polygon-create',[PolygonController:: class, 'Polygons'])->name('polygon.create');
Route::post('/admin-polygon-create',[PolygonController::class, 'store']);
// Route::get('/polygon/create',[AgriDistrictController:: class, 'PolyAgris'])->name('polygon.create');

// polygon view,edit and delete access by agent
Route::get('/admin-view-polygon',[PolygonController::class, 'polygonshow'])->name('polygon.polygons_show');
// Route::post('/admin-view-polygon',[AgriDistrictController::class, 'store']);//agri district stiore data into database
Route::get('/admin-update-agridistrict/{AgriDistrict}',[AgriDistrictController::class, 'AgriInfoEdit'])->name('agri_districts.agri_edit');;//agri district stiore data into database
Route::post('/admin-update-agridistrict/{AgriDistrict}',[AgriDistrictController::class, 'update']);//agri district stiore data into database
Route::post('/admin-delete-agridistrict/{AgriDistrict}',[AgriDistrictController::class, 'destroy'])->name('agri_districts.agri_delete');//agri district stiore data into database



//fish
Route::get('/fisheries/create',[FisheriesController::class, 'Fisheries'])->name('fish.create');
Route::post('/fisheries/create',[FisheriesController::class, 'store']);
// Route::get('/fisheries/create',[FisheriesCategoryController::class, 'Fisheries'])->name('fish.create');
// Route::get('/fisheries/create',[CategorizeController::class, 'Fisheries'])->name('fish.create');

//livestocks
Route::get('/livestocks/create',[LivestockController::class, 'Livestocks'])->name('livestocks.create');
Route::post('/livestocks/create',[LivestockController::class, 'store']);
Route::get('/livestocks/create',[CategorizeController::class, 'Livestocks'])->name('livestocks.create');
// Route::get('/livestocks/create',[LivestockCategoryController::class, 'Livestocks'])->name('livestocks.create');

//crops
Route::get('/crops/create',[CropController::class, 'Cropping'])->name('crops.create');
Route::post('/crops/create',[CropController::class, 'store']);
// Route::get('/crops/create',[CropCategoryController::class, 'Cropping'])->name('crops.create');
// Route::get('/crops/create',[CategorizeController::class, 'Cropping'])->name('crops.create');

//livestock-category
Route::get('/livestockcategory/create',[LivestockCategoryController::class, 'LivestockCategorys'])->name('livestock_category.livestock_create');
Route::post('/livestockcategory/create',[LivestockCategoryController::class, 'store']);
// Route::get('/livestockcategory/create',[CategorizeController::class, 'LivestockCategory'])->name('livestock_category.livestock_create');

//fisheries-category
Route::get('/fisheriescategory/create',[FisheriesCategoryController::class, 'FisheriesCategory'])->name('fisheries_category.fisheries_create');
Route::post('/fisheriescategory/create',[FisheriesCategoryController::class, 'store']);
// Route::get('/fisheriescategory/create',[CategorizeController::class, 'FisheriesCategory'])->name('fisheries_category.fisheries_create');

//crop-category
Route::get('/admin-add-new-crop', [CropCategoryController:: class,'CropCategory'])->name('crop_category.crop_create');
Route::post('/admin-add-new-crop',[CropCategoryController::class, 'store']);
Route::get('/admin-edit-new-crop/{cropsEdit}', [CropCategoryController:: class,'editcrop'])->name('crop_category.crop_edit');
Route::post('/admin-edit-new-crop/{cropsEdit}',[CropCategoryController::class, 'Updatecrops']);
Route::post('/admin-delete-crop/{cropsEdit}', [CropCategoryController:: class,'Deletecategory'])->name('crop_category.crop_destroy');


//catgorize router
Route::get('/admin-category', [CategorizeController:: class,'Category'])->name('categorize.index');
Route::post('/admin-category', [CategorizeController::class,'store']);

// Route::get('/admin-category', [UserController:: class,'Categories'])->name('categorize.index');
// Route::get('/admin-category', [AgriDistrictController:: class,'Category'])->name('categorize.index');

//agridistricts router
Route::get('/admin-add-district', [AgriDistrictController::class,'DisplayAgri'])->name('agri_districts.display');
Route::post('/admin-add-district', [AgriDistrictController::class,'store']);
// Route::get('/district', [UserController::class,'Mapping'])->name('agri_districts.insertdata');
// Route::post('/savePolyline', [PolygonController::class, 'savePolyline']);
// Route::post('/save',[PolygonsController::class,'save']);

//join of all tables which fetch specific column
Route::get('/joinme' ,[PersonalInformationsController::class,'Personalfarms'])->name('farm-table.join_table');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
Route::get('/personalinformation/agent',[PersonalInformationsController::class,'Agent'])->name('personalinfo.index_agent');

Route::middleware(['auth','role:admin','PreventBackHistory'])->group(function(){

    Route::get('/admin/dashboard', [AdminController::class, 'adminDashb'])->name('admin.index');

    Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
    Route::get('/admin-profile', [AdminController::class, 'AdminProfile'])->name('admin.admin_profile');
    Route::post('/admin-profile', [AdminController::class, 'update']);
    
});//end Group admin middleware
Route::get('/farmer-reports/{district}', [AdminController::class, 'getFarmerReports']);
Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login');

// create new accounts by admin access
Route::get('/new-accounts', [AdminController::class, 'newAccounts'])->name('admin.create_account.new_accounts');
Route::post('/new-accounts', [AdminController::class, 'NewUsers']);
Route::get('/view-accounts', [AdminController::class, 'Accountview'])->name('admin.create_account.display_users');
Route::get('/edit-accounts/{users}', [AdminController::class, 'editAccount'])->name('admin.create_account.edit_accounts');
Route::post('/edit-accounts/{users}', [AdminController::class, 'updateAccounts']);
Route::delete('/delete-accounts/{users}', [AdminController::class, 'deleteusers'])->name('admin.create_account.delete');
//agent route
Route::middleware(['auth','role:agent','PreventBackHistory'])->group(function(){
Route::get('/agent/dashboard', [AgentController::class, 'AgentDashboard'])->name('agent.agent_index');
Route::get('/agent/logout', [AgentController::class, 'agentlog'])->name('agent.logout');



});//end Group agent middleware

//user route
Route::middleware(['auth','role:user'])->group(function(){

    Route::get('/user/dashboard', [UserAccountController::class, 'UserDashboard'])->name('user.user_dash');
    
    Route::get('/user/logout', [UserAccountController::class, 'UserLogout'])->name('user.logout');
    
    });//end Group agent middleware

//multi importing of file into the database route
Route::get('/admin-multifile-imports', [FileController::class, 'MultiFilesAgent'])->name('multifile.import_agent');
Route::post('/admin-multifile-imports', [FileController::class, 'saveUploadForm']);
 Route::get('/admin-multifile-imports', [FileController::class, 'MultiFiles'])->name('multifile.import');
  Route::post('/admin-multifile-imports',[FileController::class, 'saveUploadForm']);
      
 // admin Map route
      Route::get('/map/gmap',[FarmProfileController::class, 'Gmap'])->name('map.gmap');
      Route::get('/agent-map-view-info/{id}',[AgentController::class, 'mapView'])->name('map.view_map_info');

      Route::get('/user-all-crops-map',[FarmProfileController::class, 'agrimap'])->name('map.agrimap');
 
      // admin Map route
      Route::get('/admin-map-arcmap',[FarmProfileController::class, 'ArcMap'])->name('map.arcmap');

     
     
      //agent  form input
      Route::get('/personalinfo/creates',[PersonalInformationsController::class, 'PersonalInfoCrudAgent'])->name('personalinfo.agent.show_agent');
   
      // view of personal info by admin ad update or dlete of info
      Route::get('/admin-view-personalinfo',[PersonalInformationsController::class, 'PersonalInfoView'])->name('personalinfo.create');
      Route::get('/admin-update-personalinfo/{personalinfos}',[PersonalInformationsController::class, 'PersonalInfoEdit'])->name('personalinfo.edit_info');
      Route::post('/admin-update-personalinfo/{personalinfos}',[PersonalInformationsController::class, 'PersonalInfoUpdate']);
      Route::post('/admin-delete-personalinfo/{personalinfos}',[PersonalInformationsController::class, 'DeletePersonalInfo'])->name('personalinfo.delete');
    //fetch information from personal informations
    Route::get('/farmprofile',[PersonalInformationsController::class ,'showPersonalInfo'])->name('farm_profile.index');

   //Personal Informations route   
Route::controller(PersonalInformationsController::class)->group(function () {
    Route::get('/admin-add-personalinformation','PersonalInfo')->name('personalinfo.index');
    Route::post('/admin-add-personalinformation', 'store')->name('personalinfo.store');

});


    // farmers edit, view and delte of farm profile info by admin
    Route::get('/admin-view-farmprofile',[ FarmProfileController::class,'ViewFarmProfile'])->name('farm_profile.farminfo_view');
    Route::get('/admin-update-farmprofile/{personalinfos}',[ FarmProfileController::class,'EditFarmProfile'])->name('farm_profile.farm_edit');
    Route::post('/admin-update-farmprofile/{personalinfos}',[ FarmProfileController::class,'UpdateFarmProfiles']);
    Route::post('/admin-delete-farmprofile/{personalinfos}',[ FarmProfileController::class,'deletetFarmProfile'])->name('farm_profile.delete');


    Route::get('/admin-view-farmer-profile/{farmProfile}',[ FarmProfileController::class,'showFarmerProfiles'])->name('farm_profile.farmer_profile');


    Route::get('/admin-add-farm/{personalinfos}',[FarmProfileController::class ,'FarmProfile'])->name('farm_profile.farm_index');
    Route::post('/admin-add-farm/{personalinfos}',[FarmProfileController::class, 'saveFarms']);

// fixed cost update, edit,delte for admin 
Route::get('/admin-view-fixedcost',[FixedCostController::class, 'FixedCostView'])->name('fixed_cost.fixed_create');
Route::get('/admin-edit-fixedcost/{fixedcosts}',[ FixedCostController::class,'editFixedcost'])->name('fixed_cost.fixed_edit');
Route::post('/admin-edit-fixedcost/{fixedcosts}', [FixedCostController::class,'updateFixedcosts']);
Route::delete('/admin-delete-fixedcost/{fixedcosts}', [FixedCostController::class, 'destroyFixedcost'])->name('fixed_cost.delete');

//fixed cost routes
Route::middleware('auth')->group(function () {
    Route::get('/admin-fixedcost', [FixedCostController::class,'FixedForms'])->name('fixed_cost.fixed_index');
    Route::post('/admin-fixedcost',[FixedCostController::class, 'store']);


});

    // machineries view, edit, and by admin access
    Route::get('/admin-view-machineries-used',[MachineriesUsedController::class, 'MachineriesVieew'])->name('machineries_used.machine_create');
    Route::get('/admin-edit-machineries-used/{machineries}',[ MachineriesUsedController::class, 'editMachineries'])->name('machineries_used.machine_edit');
    Route::post('/admin-edit-machineries-used/{machineries}', [MachineriesUsedController::class, 'updateMachineries']);
    Route::delete('/admin-delete-machineries-used/{machineries}', [MachineriesUsedController::class,'Machineriesdestroy'])->name('machineries_used.delete');

//machineries used routes
Route::middleware('auth')->group(function () {
    Route::get('/admin-machineries-used', [MachineriesUsedController::class,'MachineForms'])->name('machineries_used.machine_index');
    Route::post('/admin-machineries-used',[MachineriesUsedController::class, 'store']);
   

});

// sedds edit,view ,update and delete by admin access
  Route::get('/admin-view-variable-cost-seed',[SeedController::class, 'SeedsView'])->name('variable_cost.seeds.view');
  Route::get('/admin-edit-variable-cost-seed/{seeds}',[ SeedController::class, 'editSeeds'])->name('variable_cost.seeds.seed_edit');
  Route::post('/admin-edit-variable-cost-seed/{seeds}', [SeedController::class, 'updatesSeeds']);
  Route::delete('/admin-delete-variable-cost-seed/{seeds}', [SeedController::class,'Seedsdelete'])->name('variable_cost.seeds.delete');



//Seed routes
Route::middleware('auth')->group(function () {
    Route::get('/admin-variable-cost-seeds', [SeedController::class,'SeedsVar'])->name('variable_cost.seeds.store');
    Route::post('/admin-variable-cost-seeds',[SeedController::class, 'store']);
   
});

// labor view , edit abd delete access by admin
Route::get('/admin-view-variable-cost-labor',[LaborController::class, 'laborView'])->name('variable_cost.labor.labors_view');
Route::get('/admin-edit-variable-cost-labor/{labors}',[ LaborController::class, 'editlabor'])->name('variable_cost.labor.labors_edit');
Route::post('/admin-edit-variable-cost-labor/{labors}', [LaborController::class, 'updateslabor']);
Route::delete('/admin-delete-variable-cost-labor/{labors}', [LaborController::class,'deletel'])->name('variable_cost.labor.delete');



//labor routes
Route::middleware('auth')->group(function () {
    Route::get('/admin-variable-cost-labor', [LaborController::class,'LaborsVar'])->name('variable_cost.labor.store');
    Route::post('/admin-variable-cost-labor',[LaborController::class, 'store']);
   
});

// fertilizer view , edit abd delete access by admin
Route::get('/admin-view-variable-cost-fertilizer',[FertilizerController::class, 'fertilizerView'])->name('variable_cost.fertilizer.view');
Route::get('/admin-edit-variable-cost-fertilizer/{fertilizers}',[ FertilizerController::class, 'editfertilizer'])->name('variable_cost.fertilizer.edit');
Route::post('/admin-edit-variable-cost-fertilizer/{fertilizers}', [FertilizerController::class, 'updatesfertilizer']);
Route::delete('/admin-delete-variable-cost-fertilizer/{fertilizers}', [FertilizerController::class,'fertilizerdelete'])->name('variable_cost.fertilizer.delete');

//fertilizers route
Route::middleware('auth')->group(function () {
    Route::get('/admin-variable-cost-fertilizer', [FertilizerController::class,'FertilizersVar'])->name('variable_cost.fertilizer.store');
    Route::post('/admin-variable-cost-fertilizer',[FertilizerController::class, 'store']); 
  
});

// pesticides view , edit abd delete access by admin
Route::get('/admin-view-variable-cost-pesticides',[PesticideController::class, 'pestView'])->name('variable_cost.pesticides.view');
Route::get('/admin-edit-variable-cost-pesticides/{pesticides}',[ PesticideController::class, 'editpest'])->name('variable_cost.pesticides.pest_edit');
Route::post('/admin-edit-variable-cost-pesticides/{pesticides}', [PesticideController::class, 'updateslaborpest']);
Route::delete('/admindelete-variable-cost-pesticides/{pesticides}', [PesticideController::class,'pestdelete'])->name('variable_cost.pesticides.delete');

//pesticides routes
Route::middleware('auth')->group(function () {
    Route::get('/admin-variable-cost-pesticides', [PesticideController::class,'PesticidesVar'])->name('variable_cost.pesticides.store');
    Route::post('/admin-variable-cost-pesticides',[PesticideController::class, 'store']);
   
});

// transport view , edit abd delete access by admin
Route::get('/admin-view-variable-cost-transport',[TransportController::class, 'trasnportView'])->name('variable_cost.transport.show');
Route::get('/admin-edit-variable-cost-transport/{transports}',[ TransportController::class, 'edittransport'])->name('variable_cost.transport.update');
Route::post('/admin-edit-variable-cost-transport/{transports}', [TransportController::class, 'updatestransport']);
Route::delete('/admin-delete-variable-cost-transport/{transports}', [TransportController::class,'transportdelete'])->name('variable_cost.transport.delete');



//transport routes
Route::middleware('auth')->group(function () {
  Route::get('/admin-variable-cost-transport', [TransportController::class,'TransportVar'])->name('variable_cost.transport.store');
    Route::post('/admin-variable-cost-transport',[TransportController::class, 'store']);
   
});

// varaible cost view , edit abd delete access by admin
Route::get('/admin-view-variable-cost',[VariableCostController::class, 'varView'])->name('variable_cost.var_show');
Route::get('/admin-edit-variable-cost/{variable}',[ VariableCostController::class, 'editvar'])->name('variable_cost.var_update');
Route::post('/admin-edit-variable-cost/{variable}', [VariableCostController::class, 'updatesvar']);
Route::delete('/admin-delete-variable-cost/{variable}', [VariableCostController::class,'vardelete'])->name('variable_cost.delete');




//variable cost routes
Route::middleware('auth')->group(function () {
Route::get('/admin-variablecost', [VariableCostController::class,'VariableForms'])->name('variable_cost.index');
Route::post('/admin-variablecost',[VariableCostController::class, 'store']);
    
  });
  

  
//last Productions Data routes
Route::middleware('auth')->group(function () {
    Route::get('/admin-lastproduction-data', [LastProductionDataController::class,'ProductionForms'])->name('production_data.index');
    Route::post('/admin-lastproduction-data',[LastProductionDataController::class, 'store']);
    Route::get('/admin-view-lastproduction-data',[LastProductionDataController::class, 'Productionview'])->name('production_data.production_create');
    Route::get('/admin-edit-lastproduction-data/{productions}',[ LastProductionDataController::class, 'Prodedit'])->name('production_data.production_edit');
    Route::post('/admin-edit-lastproduction-data/{productions}', [LastProductionDataController::class, 'Proddataupdate']);
    Route::delete('/admin-delete-lastproduction-data/{productions}', [LastProductionDataController::class, 'ProdDestroy'])->name('production_data.delete');
});





