<?php

    include_once  __DIR__ . '/../include/default/defaultController.php';

    include_once  __DIR__ . '/../include/model/colaboratorAddressDAO.php';
    include_once  __DIR__ . '/../include/model/colaboratorDAO.php';
    include_once  __DIR__ . '/../include/model/colaboratorTypeDAO.php';
    include_once  __DIR__ . '/../include/model/logControllerDAO.php';
    include_once  __DIR__ . '/../include/model/logDAO.php';
    include_once  __DIR__ . '/../include/model/loginDAO.php';
    include_once  __DIR__ . '/../include/model/paymentDAO.php';
    include_once  __DIR__ . '/../include/model/paymentOrderDAO.php';
    include_once  __DIR__ . '/../include/model/paymentOrderHasColaboratorDAO.php';
    include_once  __DIR__ . '/../include/model/paymentTypeDAO.php';
    include_once  __DIR__ . '/../include/model/tutorialDAO.php';
    include_once  __DIR__ . '/../include/model/tutorialItemDAO.php';
    include_once  __DIR__ . '/../include/model/tutorialTypeDAO.php';
    include_once  __DIR__ . '/../include/model/userAddressDAO.php';
    include_once  __DIR__ . '/../include/model/userDAO.php';
    include_once  __DIR__ . '/../include/model/userInterestDAO.php';
    include_once  __DIR__ . '/../include/model/userPermissionDAO.php';
    include_once  __DIR__ . '/../include/model/userTypeDAO.php';
    include_once  __DIR__ . '/../include/model/viewTutorialDAO.php';

Class Controller extends DefaultController{

    function __construct(){

        try{

            $this->colaboratorAddressDAO = new ColaboratorAddressDAO($this->masterMysqli);
            $this->colaboratorDAO = new ColaboratorDAO($this->masterMysqli);
            $this->colaboratorTypeDAO = new ColaboratorTypeDAO($this->masterMysqli);
            $this->logControllerDAO = new LogControllerDAO($this->masterMysqli);
            $this->logDAO = new LogDAO($this->masterMysqli);
            $this->loginDAO = new LoginDAO($this->masterMysqli);
            $this->paymentDAO = new PaymentDAO($this->masterMysqli);
            $this->paymentOrderDAO = new PaymentOrderDAO($this->masterMysqli);
            $this->paymentOrderHasColaboratorDAO = new PaymentOrderHasColaboratorDAO($this->masterMysqli);
            $this->paymentTypeDAO = new PaymentTypeDAO($this->masterMysqli);
            $this->tutorialDAO = new TutorialDAO($this->masterMysqli);
            $this->tutorialItemDAO = new TutorialItemDAO($this->masterMysqli);
            $this->tutorialTypeDAO = new TutorialTypeDAO($this->masterMysqli);
            $this->userAddressDAO = new UserAddressDAO($this->masterMysqli);
            $this->userDAO = new UserDAO($this->masterMysqli);
            $this->userInterestDAO = new UserInterestDAO($this->masterMysqli);
            $this->userPermissionDAO = new UserPermissionDAO($this->masterMysqli);
            $this->userTypeDAO = new UserTypeDAO($this->masterMysqli);
            $this->viewTutorialDAO = new ViewTutorialDAO($this->masterMysqli);

            $this->return = array('error'=> false, 'data'=> array(), 'message'=>'');

        }catch(Exception $e){
            $this->return($e);
        }
    }
}
?>