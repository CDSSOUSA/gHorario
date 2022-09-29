<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\YearSchoolModel;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['utils', 'form'];
    
    /**
     * messageErro
     *
     * @var array
     */
    protected $messageErro = [
        'message' => '<i class="bi bi-exclamation-octagon me-1"></i> Ops! Erro(s) no preenchimento!',
        'alert' => 'danger'
    ];
    
    /**
     * messageSuccess
     *
     * @var array
     */
    protected $messageSuccess = [
        'message' => '<i class="bi bi-check-circle me-1"></i> Parabéns! Operação realizada com sucesso!',
        'alert' => 'success'
    ];

    protected $yearSchoolActive;

    public $javascript = [];
    public $style = [];

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
        //helper('utils');       

        $t = new YearSchoolModel();
        $this->yearSchoolActive = $t->where('status','A')->find()[0];
        session()->set('session_idYearSchool', $this->yearSchoolActive->id);
        session()->set('session_DescriptionYearSchool', $this->yearSchoolActive->description);

        $this->style = [
            
                "https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback",
                base_url() . "/assets/plugins/fontawesome-free/css/all.min.css",
                "https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css",
                base_url() . "/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css",
                base_url() . "/assets/plugins/jqvmap/jqvmap.min.css",
                base_url() . "/assets/dist/css/adminlte.min.css?v=3.2.0",
                base_url() . "/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css",
                //base_url() . "/assets/css/jquery-ui.css",
                "https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.css",
                base_url() . "/assets/css/style.css",
                //base_url() . "/assets/css/jquery-ui.css",
                "https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css",
                "https://cdn.datatables.net/fixedcolumns/4.1.0/css/fixedColumns.dataTables.min.css",
                
            
        ];       

        $this->javascript = [
            
                base_url() . "/assets/js/jquery.min.js",
                base_url() . "/assets/plugins/jquery-ui/jquery-ui.js",
                base_url() . "/assets/plugins/bootstrap/js/bootstrap.bundle.min.js",
                base_url() . "/assets/plugins/moment/moment.min.js",
                base_url() . "/assets/plugins/summernote/summernote-bs4.min.js",
                base_url() . "/assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js",
                base_url() . "/assets/plugins/bootstrap-switch/js/bootstrap-switch.js",
                base_url() . "/assets/plugins/toastr/toastr.min.js",
                base_url() . "/assets/dist/js/adminlte.js?v=3.2.0",
                "https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.js",
                //base_url() . "/assets/js/jquery.mask.min.js",
                //base_url() . "/assets/js/jquery.maskMoney.js",
                base_url() . "/assets/js/axios.min.js",
                base_url() . "/assets/js/utils.js",
                // base_url() . "/assets/js/script.js",
                // base_url() . "/assets/js/school-schedule.js",
                // base_url() . "/assets/js/year-school.js",
                // base_url() . "/assets/js/series.js",
                // base_url() . "/assets/js/teacher.js",
                // base_url() . "/assets/js/discipline.js",
                "https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js",
                "https://cdn.datatables.net/fixedcolumns/4.1.0/js/dataTables.fixedColumns.min.js",
                
           
        ];

    }
}
