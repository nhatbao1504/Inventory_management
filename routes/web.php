<?php

use App\Http\Controllers\ContractController;
use App\Http\Controllers\EarnLeaveController;
use App\Http\Controllers\LeaveApplicationController;
use App\Http\Controllers\ProposalApplicationController;
use App\Http\Controllers\ProposalTypesController;
use App\Http\Controllers\QuizController;
use App\StaticString;
use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;

use App\Http\Controllers\MaterialsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\HolidaysController;
use App\Http\Controllers\LeaveTypeController;
use App\Http\Controllers\LeaveReportsController;
use App\Http\Controllers\MyXteamController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\RecognitionController;
use App\Http\Controllers\RecognitionTypeController;
use App\Http\Controllers\DisciplinaryController;
use App\Http\Controllers\DisciplinaryTypeController;
use App\Http\Controllers\CreateQuizController;
use App\Http\Controllers\TestQuizController;
use App\Http\Controllers\InternalCertificatesController;
use App\Http\Controllers\WorkshopController;
use App\Http\Controllers\ProjectBudgetController;

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

Route::get('/login', 'App\Http\Controllers\LoginController@getViewLogin');
Route::post('/9EqClX7gzeiZAQ2wtsghJxIfR3irIM375lq8LPTRS2A7sG9tvcRmyVTor00PiYBE', 'App\Http\Controllers\AccountController@position');
Route::post('/login', 'App\Http\Controllers\LoginController@postLogin');
Route::get('/logout', 'App\Http\Controllers\LoginController@logOut');
Route::post('/position', 'App\Http\Controllers\AccountController@position');


Route::group(['prefix' => '/', 'middleware' => 'isLogin'], function () {
    Route::get('/', function () {
        return redirect('/dashboard');
    })->name('root');
    Route::get('/dashboard', 'App\Http\Controllers\DashboardController@getViewDashboard')->name('home');
    Route::post('/dashboard/update-todo', 'App\Http\Controllers\DashboardController@UpdateTodo');
    Route::post('/dashboard/update-sub-todo', 'App\Http\Controllers\DashboardController@UpdateSubTodo');

    Route::get('/login-history', 'App\Http\Controllers\AccountController@loginHistory');
    Route::group(['prefix' => '/account', 'middleware' => 'isAdmin'], function () {
        Route::get('/', 'App\Http\Controllers\AccountController@getView');
        Route::put('/add', 'App\Http\Controllers\AccountController@add');
        Route::post('/update', 'App\Http\Controllers\AccountController@update');
        Route::delete('/delete', 'App\Http\Controllers\AccountController@delete');


        Route::delete('/clear-history', 'App\Http\Controllers\AccountController@clearHistory');

        Route::get('/demo', function () {
            return view('auth.account.account_import_demo');
        });
        Route::get('/demo', 'App\Http\Controllers\AccountController@demoView');
        Route::post('/demo', 'App\Http\Controllers\AccountController@import');
    });

    Route::group(['prefix' => '/customer'], function () {
        Route::get('/', 'App\Http\Controllers\CustomerController@getView');
        Route::put('/add', 'App\Http\Controllers\CustomerController@add');
        Route::get('/{customer_id}', 'App\Http\Controllers\CustomerController@getUpdateView');
        Route::post('/update', 'App\Http\Controllers\CustomerController@update');
        Route::delete('/delete', 'App\Http\Controllers\CustomerController@delete');
        Route::get('/query', 'App\Http\Controllers\CustomerController@query');
    });
    Route::group(['prefix' => '/contract'], function () {
        Route::get('/', 'App\Http\Controllers\ContractController@getView');
    });


    Route::group(['prefix' => '/team', 'middleware' => 'isSuperAdmin'], function () {
        Route::get('/', 'App\Http\Controllers\TeamController@getView');
        Route::put('/add', 'App\Http\Controllers\TeamController@add');
        Route::post('/update', 'App\Http\Controllers\TeamController@update');
        Route::delete('/delete', 'App\Http\Controllers\TeamController@delete');

        Route::get('/{team_id}/employees', 'App\Http\Controllers\TeamDetailsController@getView')->name('team.employees');
        ;
        Route::post('/update-employees', 'App\Http\Controllers\TeamDetailsController@update');
        Route::post('/update-position', 'App\Http\Controllers\TeamDetailsController@updatePosition');

        Route::put('/add-from-project', 'App\Http\Controllers\TeamController@addFromProject');
    });

    Route::group(['prefix' => '/lms'], function () {
        Route::get('', 'App\Http\Controllers\LMSDashboardController@getView');
        Route::get('/workshops', 'App\Http\Controllers\WorkshopController@getViewDashboard');
        Route::get('workshops', [WorkshopController::class, 'index'])->name('workshop.index');
        Route::post('/workshop', [WorkshopController::class, 'add'])->name('workshop.store');
        Route::get('/workshop/{workshop_id}', [WorkshopController::class, 'show'])->name('workshop.show');
        Route::put('/workshop/update', [WorkshopController::class, 'update'])->name('workshop.update');
        Route::get('/live/{workshop_id}', [WorkshopController::class, 'live'])->name('lms.live');

        //Courses
        Route::get('/courses', 'App\Http\Controllers\CourseController@getViewCourses')->name('lms.course');
        Route::post('/course', 'App\Http\Controllers\CourseController@create');
        Route::get('/course/{id}', 'App\Http\Controllers\CourseController@getCourse');
        Route::get('/course/{id}/view', 'App\Http\Controllers\CourseController@getCourseView');
        Route::post('/course/update', 'App\Http\Controllers\CourseController@updateCourse');
        Route::delete('/course/delete', 'App\Http\Controllers\CourseController@deleteCourse');

        //Sections
        Route::post('/course/getSection', 'App\Http\Controllers\CourseController@getCourseSection')->name('course.getSection');
        Route::post('/course/createSection', 'App\Http\Controllers\CourseController@createSection');
        Route::post('/course/updateSection', 'App\Http\Controllers\CourseController@updateSection');
        Route::delete('/course/deleteSection', 'App\Http\Controllers\CourseController@deleteSection');
        Route::post('/course/join', 'App\Http\Controllers\CourseController@joinCourse');
        Route::get('/mycourses/export', 'App\Http\Controllers\LMSDashboardController@export')->name('courses.export');
    });

    Route::group(['prefix' => '/certificate_types', 'middleware' => 'isAdmin'], function () {
        Route::get('/', 'App\Http\Controllers\CertificateTypeController@getView');
        Route::post('/add', 'App\Http\Controllers\CertificateTypeController@add');
        Route::post('/update', 'App\Http\Controllers\CertificateTypeController@update');
        Route::post('/delete', 'App\Http\Controllers\CertificateTypeController@delete');
    });
    Route::group(['prefix' => '/job-info', 'middleware' => 'isAdmin'], function () {
        Route::get('/', 'App\Http\Controllers\JobInfoController@getView');
        Route::post('/get', 'App\Http\Controllers\JobInfoController@getJob');
        Route::post('/add', 'App\Http\Controllers\JobInfoController@add');
        Route::post('/update', 'App\Http\Controllers\JobInfoController@update');
        Route::post('/delete', 'App\Http\Controllers\JobInfoController@delete');
    });
    Route::group(['prefix' => '/employees', 'middleware' => 'isAdmin'], function () {
        Route::get('/', 'App\Http\Controllers\EmployeesController@getView');
        Route::get('/import', 'App\Http\Controllers\EmployeesController@importView');
        Route::get('/update/{employee_id}', 'App\Http\Controllers\EmployeesController@updateView');
        Route::get('/inactive', 'App\Http\Controllers\EmployeesController@inactiveView');
        Route::post('/updateEmployee', 'App\Http\Controllers\EmployeesController@post');
        Route::put('/addEmployee', 'App\Http\Controllers\EmployeesController@put');
        Route::delete('/deleteEmployee', 'App\Http\Controllers\EmployeesController@delete');
        Route::get('/info/{employee_id}', 'App\Http\Controllers\EmployeesController@getEmployee');
        Route::post('/check_file_exists', 'App\Http\Controllers\EmployeesController@checkFileExists');
        Route::post('/delete_file', 'App\Http\Controllers\EmployeesController@deleteFile');
        Route::post('/loadExcel', 'App\Http\Controllers\EmployeesController@loadExcel');
        Route::post('/importEmployee', 'App\Http\Controllers\EmployeesController@import');
        Route::get('/exportEmployee', 'App\Http\Controllers\EmployeesController@export');
    });

    Route::post('img-upload', 'App\Http\Controllers\UploadFileController@imgUpload')->name('img-upload');
    Route::post('img-store', 'App\Http\Controllers\UploadFileController@imgStore')->name('img-store');
    Route::delete('img-delete', 'App\Http\Controllers\UploadFileController@imgDelete')->name('img-delete');
    //File attachments
    Route::post('attachment-upload', 'App\Http\Controllers\UploadAttachmentController@attachmentUpload')->name('attachment-upload');
    Route::post('attachment-store', 'App\Http\Controllers\UploadAttachmentController@attachmentStore')->name('attachment-store');
    Route::delete('attachment-delete', 'App\Http\Controllers\UploadAttachmentController@attachmentDelete')->name('attachment-delete');

    Route::group(['prefix' => '/profile'], function () {
        Route::get('/{employee_id}', 'App\Http\Controllers\ProfileController@getViewProfile');
        Route::post('/update', 'App\Http\Controllers\ProfileController@postProfile');
        Route::post('/change-password', 'App\Http\Controllers\ProfileController@changePassword');
    });

    Route::group(['prefix' => '/leave'], function () {
        //Holiday
        Route::resource('/holidays', HolidaysController::class);
        Route::get('/holidays', [HolidaysController::class, 'getView'])->name('holidays.index');
        Route::post('/holidays', [HolidaysController::class, 'store'])->name('holidays.store');
        Route::get('/holidays/{holidays}/edit', [HolidaysController::class, 'edit'])->name('holidays.edit');
        Route::put('/holidays/{holidays}', [HolidaysController::class, 'update'])->name('holidays.update');
        Route::delete('/holidays/{holidays}', [HolidaysController::class, 'destroy'])->name('holidays.destroy');
        Route::get('/holidayst/export', [HolidaysController::class, 'exportExcel'])->name('holidays.export');

        //Leave Type
        Route::resource('/leave-type', LeaveTypeController::class);
        Route::get('/leave-type', [LeaveTypeController::class, 'getView'])->name('leave-type.index');
        Route::post('/leave-type', [LeaveTypeController::class, 'store'])->name('leave-type.store');
        Route::get('/leave-type/{leave-type}/edit', [LeaveTypeController::class, 'edit'])->name('leave-type.edit');
        Route::put('/leave-type/{leave-type}', [LeaveTypeController::class, 'update'])->name('leave-type.update');
        Route::delete('/leave-type/{leave-type}', [LeaveTypeController::class, 'destroy'])->name('leave-type.destroy');

        //Leave Application
        Route::get('/leave-application', [LeaveApplicationController::class, 'getView'])->name('leave-application.index');
        Route::post('/leave-application/add', [LeaveApplicationController::class, 'add'])->name('leave-application.add');
        Route::get('/leave-application/{id}/edit', [LeaveApplicationController::class, 'edit'])->name('leave-application.edit');
        Route::put('/leave-application/{id}/update', [LeaveApplicationController::class, 'update'])->name('leave-application.update');
        Route::delete('/leave-application/{id}/delete', [LeaveApplicationController::class, 'destroy'])->name('leave-application.destroy');

        //Leave Report
        Route::get('/leave-report', [LeaveReportsController::class, 'getView'])->name('leave-report.index');
        Route::post('/leave-report/search', [LeaveReportsController::class, 'searchReports'])->name('leave-report.search');
        Route::put('/leave-applications/{id}/approve', [LeaveReportsController::class, 'approveLeaveApplication'])->name('leave-applications.approve');
        Route::delete('/leave-report/{id}/delete', [LeaveReportsController::class, 'destroy'])->name('leave-report.destroy');

        Route::get('/leave-report/data', [LeaveReportsController::class, 'getLeaveApplications'])->name('leave-report.data');
        Route::get('/leave-report/export', [LeaveReportsController::class, 'exportExcel'])->name('leave-report.export');


        //Earn Leave
        Route::get('/earn-leave', [EarnLeaveController::class, 'getView'])->name('earn-leave.index');
    });
    Route::post('/upload', 'App\Http\Controllers\UploadFileController@uploadFile');
    Route::post('/upload_photo', 'App\Http\Controllers\UploadFileController@uploadPhoto');
    Route::post('/upload_personal_profile', 'App\Http\Controllers\UploadFileController@uploadPersonalProfile');
    Route::post('/upload_medical_checkup', 'App\Http\Controllers\UploadFileController@uploadMedicalCheckUp');
    Route::post('/upload_certificate', 'App\Http\Controllers\UploadFileController@uploadCertificate');
    Route::post('/upload_employment_contract', 'App\Http\Controllers\UploadFileController@uploadEmploymentContract');


    Route::get('/projects', [\App\Http\Controllers\ProjectController::class, 'getView'])->name('project.projects');
    Route::post('/projects', [\App\Http\Controllers\ProjectController::class, 'InsPJ'])->name('projects.insert');
    Route::get('/projects/{project_id}/attachments', 'App\Http\Controllers\ProjectController@getAttachmentView');
    Route::get('/projects/{project_id}/attachments/{location_id}', 'App\Http\Controllers\ProjectController@getDateAttachments');
    Route::get('/projects/{project_id}/attachments/{location_id}/{date}', 'App\Http\Controllers\ProjectController@getFileAttachments');

    Route::get('/materials', [MaterialsController::class, 'getView'])->name('materials.index');
    Route::post('/materials', [MaterialsController::class, 'store'])->name('materials.store');
    Route::get('materials/{id}/edit', [MaterialsController::class, 'edit'])->name('materials.edit');
    Route::put('materials/{id}', [MaterialsController::class, 'update'])->name('materials.update');
    Route::delete('materials/{id}', [MaterialsController::class, 'destroy'])->name('materials.destroy');
    Route::get('materials/{id}', [MaterialsController::class, 'show'])->name('materials.show');


    //Progress
    Route::post('/update-item', [ProgressController::class, 'updateItem']);
    Route::get('/task/task/{id}', [TaskController::class, 'showTask'])->name('task.getTasksData');
    Route::get('/task/subtask/{id}', [TaskController::class, 'showSubTask'])->name('task.getSubTasksData');
    Route::post('/progress', [TaskController::class, 'create'])->name('task.create');
    Route::post('/task/update', [TaskController::class, 'update'])->name('task.update');
    Route::get('/project/{id}/progress', [ProgressController::class, 'getViewHasID'])->name('project.progress');
    Route::post('/task/delete/{id}', [TaskController::class, 'delete'])->name('task.delete');

    //Settings
    Route::get('/setting', [SettingsController::class, 'getView'])->name('settings.view');
    Route::post('/setting', [SettingsController::class, 'updateForm'])->name('setting.update');

    Route::get('/task', [TaskController::class, 'getView'])->name('task.index');
    Route::get('/phase/{phase}', [TaskController::class, 'showPhaseTasks'])->name('phase.tasks');
    Route::get('/task/{task}', [TaskController::class, 'showTaskSubtasks'])->name('task.subtasks');


    Route::group(['prefix' => '/project'], function () {
        //show details and update project
        Route::get('/{id}', [\App\Http\Controllers\ProjectBudgetController::class, 'showProjectDetail'])->name('project.details');
        Route::put('/{id}/update', [\App\Http\Controllers\ProjectBudgetController::class, 'update'])->name('project.update');
        //List of Expenses
        Route::get('/{id}/budget', '\App\Http\Controllers\ProjectBudgetController@getView')->name('budget');
        Route::get('/project/{id}/budget/group-details/{group_id}', [\App\Http\Controllers\ProjectBudgetController::class, 'viewCost'])->name('budget.viewCost');
        Route::get('/{id}/budget/data/{costGroupId}/{costId}', [\App\Http\Controllers\ProjectBudgetController::class, 'getBudgetData'])->name('budget.data');
        Route::post('/{id}/budget/data/{costGroupId}/{costId}/update', [\App\Http\Controllers\ProjectBudgetController::class, 'updateBudget'])->name('budget.update');
        Route::post('/budget/rename-cost-group', [\App\Http\Controllers\ProjectBudgetController::class, 'renameCostGroup'])->name('budget.renameCostGroup');
        Route::post('/{id}/budget/create-group', [\App\Http\Controllers\ProjectBudgetController::class, 'createCostGroup'])->name('budget.createCostGroup');
        Route::get('/{id}/budget/cost-group-details/{group_id}', [\App\Http\Controllers\ProjectBudgetController::class, 'getCostGroupDetails'])->name('budget.getCostGroupDetails');
        Route::post('/{id}/budget/add-new-cost', [\App\Http\Controllers\ProjectBudgetController::class, 'addNewCost'])->name('budget.addNewCost');
        Route::get('/project/{id}/budget/export-csv', [\App\Http\Controllers\ProjectBudgetController::class, 'cost_exportCsv'])->name('budget.cost-export-csv');

        //List of Commission
        Route::get('/{id}/commission', [\App\Http\Controllers\ProjectBudgetController::class, 'getViewCommission'])->name('commission');
        Route::post('/{id}/commission/details', [\App\Http\Controllers\ProjectBudgetController::class, 'getCommissionDetails'])->name('commission.details');
        Route::get('/{id}/export-csv', [\App\Http\Controllers\ProjectBudgetController::class, 'exportCsv'])->name('budget.export.csv');
        Route::delete('/{project_id}/commission/{cost_commission_id}', [\App\Http\Controllers\ProjectBudgetController::class, 'deleteCostCommission'])->name('budget.deleteCommission');
        Route::put('/{project_id}/commission/{commission_id}', [\App\Http\Controllers\ProjectBudgetController::class, 'updateCommission'])->name('budget.updateCommission');
        Route::post('/{project_id}/commission/add-new-commission', [\App\Http\Controllers\ProjectBudgetController::class, 'addNewCommission'])->name('budget.addNewCommission');
        Route::put('/{project_id}/commission/{group_id}/edit', [\App\Http\Controllers\ProjectBudgetController::class, 'editNameGroup'])->name('budget.editNameGroup');

        Route::get('/{project_id}/commission/commision-group-details/{group_id}', [\App\Http\Controllers\ProjectBudgetController::class, 'getGroupCommissionDetails'])->name('budget.getGroupCommissionDetails');

        Route::get('/{project_id}/report', [ProjectBudgetController::class, 'report'])->name('project.report');
    });

    Route::group(['prefix' => '/myxteam', 'middleware' => 'isSuperAdmin'], function () {
        Route::get('teams', [MyXteamController::class, 'getView']);
        Route::get('team/{WorkspaceId}/project', [MyXteamController::class, 'getTeamProjects']);
        Route::get('team/{WorkspaceId}/project/{ProjectId}/tasks', [MyXteamController::class, 'getProjectTasks']);
        Route::post('team/{WorkspaceId}/project/{ProjectId}/task/{TaskId}', [MyXteamController::class, 'updateTask']);
    });

    //Inventory Management
    Route::get('inventory', [\App\Http\Controllers\InventoryManagementController::class, 'getView'])->name('inventory');

    //Order
    Route::get('/order', [\App\Http\Controllers\OrderController::class, 'getView'])->name('order');

    //Department
    Route::resource('departments', DepartmentController::class);
    Route::get('/departments', [\App\Http\Controllers\DepartmentController::class, 'getView'])->name('departments.index');
    Route::post('/departments', [DepartmentController::class, 'store'])->name('departments.store');
    Route::get('departments/{department}/edit', [DepartmentController::class, 'edit'])->name('departments.edit');
    Route::put('departments/{department}', [DepartmentController::class, 'update'])->name('departments.update');
    Route::delete('departments/{department}', [DepartmentController::class, 'destroy'])->name('departments.destroy');

    //Attendance
    Route::get('/attendance', [AttendanceController::class, 'getView'])->name('attendance.index');
    Route::get('/attendance/add', [AttendanceController::class, 'addAttendanceView'])->name('attendance.addIndex');
    Route::get('/attendance/{id}', [AttendanceController::class, 'viewAttendanceByID'])->name('attendance.viewID');
    Route::post('/attendance/add', [AttendanceController::class, 'addAttendance'])->name('attendance.add');
    Route::post('/attendance/update', [AttendanceController::class, 'updateAttendance'])->name('attendance.update');
    Route::delete('/attendance/delete', [AttendanceController::class, 'deleteAttendance'])->name('attendance.delete');

    //Proposal-Types
    Route::get('proposal-types', [ProposalTypesController::class, 'getView'])->name('proposal-types.index');
    Route::post('/proposal-types/add', [ProposalTypesController::class, 'add'])->name('proposal-types.add');
    Route::get('/proposal-types/{id}/show', [ProposalTypesController::class, 'show'])->name('proposal-types.show');
    Route::put('/proposal-types/{id}/update', [ProposalTypesController::class, 'update'])->name('proposal-types.update');
    Route::delete('/proposal-types/{id}/destroy', [ProposalTypesController::class, 'destroy'])->name('proposal-types.destroy');
    Route::get('/proposal-types/export', [ProposalTypesController::class, 'exportExcel'])->name('proposal-types.export');

    //Proposal-Application
    Route::get('/proposal', [ProposalApplicationController::class, 'getView'])->name('proposal-application.index');
    Route::post('/proposal/add', [ProposalApplicationController::class, 'add'])->name('proposal-application.add');
    Route::get('/proposal/{id}/edit', [ProposalApplicationController::class, 'edit'])->name('proposal-application.edit');
    Route::put('/proposal/{id}/update', [ProposalApplicationController::class, 'update'])->name('proposal-application.update');
    Route::delete('/proposal/{id}', [ProposalApplicationController::class, 'destroy'])->name('proposal-application.destroy');
    Route::delete('/proposal/remove-file/{id}', [ProposalApplicationController::class, 'removeFile'])->name('proposal-application.removeFile');
    Route::post('/proposal/approve/{id}/{permission}', [ProposalApplicationController::class, 'approve'])->name('proposal-application.approve');
    Route::get('/proposal/export', [ProposalApplicationController::class, 'exportExcel'])->name('proposal-application.export');

    Route::get('/portfolio', [PortfolioController::class, 'getView'])->name('portfolio');
    Route::get('/portfolio/{id}', [PortfolioController::class, 'getViewHasId'])->name('portfolio.id');


    // recognition
    Route::group(['prefix' => '/recognition', 'middleware' => 'isSuperAdmin'], function () {
        Route::get('', [RecognitionController::class, 'getView'])->name('recognition.view');
        Route::get('/type', [RecognitionTypeController::class, 'getView'])->name('recognitiontype.index');
        Route::post('/add', [RecognitionController::class, 'add'])->name('recognition.add');
        Route::post('/addType', [RecognitionController::class, 'addType'])->name('recognition.addType');
        Route::post('/import', [RecognitionController::class, 'import'])->name('recognition.import');
        Route::post('/update', [RecognitionController::class, 'update'])->name('recognition.update');
        Route::get('/{recognition_id}', [RecognitionController::class, 'get'])->name('recognition.get');
    });

    // disciplinary
    Route::group(['prefix' => '/disciplinary', 'middleware' => 'isSuperAdmin'], function () {
        Route::get('', [DisciplinaryController::class, 'getView'])->name('disciplinary.view');
        Route::get('/type', [DisciplinaryTypeController::class, 'getView'])->name('disciplinarytype.index');
        Route::post('/add', [DisciplinaryController::class, 'add'])->name('disciplinary.add');
        Route::post('/addType', [DisciplinaryController::class, 'addType'])->name('disciplinary.addType');
        Route::post('/import', [DisciplinaryController::class, 'import'])->name('disciplinary.import');
        Route::post('/update', [DisciplinaryController::class, 'update'])->name('disciplinary.update');
        Route::get('/{disciplinary_id}', [DisciplinaryController::class, 'get'])->name('disciplinary.get');
    });

    Route::group(['prefix' => '/quiz'], function () {
        Route::get('', [QuizController::class, 'getView'])->name('quiz.index');
        Route::get('/test-quiz', [TestQuizController::class, 'getView'])->name('test-quiz.index');
        Route::get('/create-quiz', [CreateQuizController::class, 'getView'])->name('create-quiz.index');

        Route::get('/question-bank', [QuizController::class, 'getViewQuestionBank'])->name('question-bank.index');
        Route::post('/question-bank/add', [QuizController::class, 'addQuestion'])->name('question-bank.add');
        Route::get('/question-bank/list/{id}', [QuizController::class, 'getQuestionList'])->name('question-bank.list');
        Route::delete('/question-bank/{id}', [QuizController::class, 'destroy'])->name('question-bank.destroy');
        Route::get('/question-bank/{id}/edit', [QuizController::class, 'edit'])->name('question-bank.edit');
        Route::post('/question-bank/{id}/update', [QuizController::class, 'update'])->name('question-bank.update');


    });

    Route::get('certificate', [InternalCertificatesController::class, 'getViewUser'])->name('certificate.user');
    Route::get('certificateType', [InternalCertificatesController::class, 'getViewType'])->name('certificate.type');


    Route::get('certificate', [InternalCertificatesController::class, 'getViewUser'])->name('certificate.user');
    Route::delete('certificate', [InternalCertificatesController::class, 'deleteViewUser'])->name('certificate.user.delete');
    Route::get('certificateType', [InternalCertificatesController::class, 'getViewType'])->name('certificate.type');
    Route::delete('certificateType', [InternalCertificatesController::class, 'deleteType'])->name('certificate.type.delete');
    Route::post('certificateType/post', [InternalCertificatesController::class, 'updateCertificateType'])->name('certificate.type.update');
    Route::post('certificateType/add', [InternalCertificatesController::class, 'addCertificateType'])->name('certificate.type.add');
    Route::get('certificateType/temp', [InternalCertificatesController::class, 'temp'])->name('certificate');
    Route::get('certificateType/signature', [InternalCertificatesController::class, 'getViewSignature'])->name('certificate.signature');
    Route::get('certificateType/create', [InternalCertificatesController::class, 'getViewCreate'])->name('certificate.create');

    Route::get('lang/{locale}', function ($locale) {
        if (in_array($locale, ['en', 'vi'])) {
            session(['locale' => $locale]);
        }
        return redirect()->back();
    });
});

// Language - chuyển đổi ngôn ngữ
Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'vi'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
});

// Tạo liên kết chuyển đổi
//<a href="{{ url('lang/en') }}">English</a>
//<a href="{{ url('lang/vi') }}">Tiếng Việt</a>
