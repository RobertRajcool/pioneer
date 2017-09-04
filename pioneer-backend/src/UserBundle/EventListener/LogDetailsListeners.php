<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 29/11/16
 * Time: 12:24 PM
 */

namespace UserBundle\EventListener;


use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;
use PDO;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Configuration;
use Symfony\Component\HttpFoundation\Session\Session;


class LogDetailsListeners
{

    private $container;
    private $session = null;
    private $dbHost;
    private $dbUser;
    private $dbPassword;
    private $dbName;


    public function __construct(ContainerInterface $container, Session $session, $dbHost, $dbUser, $dbPassword,$dbName) {
        $this->container = $container;
        $this->session = $session;
        $this->dbHost = $dbHost;
        $this->dbUser = $dbUser;
        $this->dbPassword = $dbPassword;
        $this->dbName=$dbName;
    }
    public function preUpdate(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        $entityReflected = new \ReflectionObject($entity);
        $reader = new \Doctrine\Common\Annotations\AnnotationReader();
        $classAnnotations = $reader->getClassAnnotations($entityReflected);
        $changeSets = $eventArgs->getEntityChangeSet();
        $table = get_class($entity);
        $needMaintainLogs=array(
            'VesselBundle\Entity\Shipdetails',
            'DashboardBundle\Entity\IncidentCost',
            'DashboardBundle\Entity\IncidentDetails',
            'DashboardBundle\Entity\IncidentFirstInfo',
            'DashboardBundle\Entity\IncidentOperatorWeather',
            'DashboardBundle\Entity\OperationattimeofIncident',
            'DashboardBundle\Entity\TypeofCause',
            'DashboardBundle\Entity\TypeofIncident',

        );
        $needTologMaintain = false;

       if (in_array($table, $needMaintainLogs)) {
            $needTologMaintain = true;
        }
        if ($needTologMaintain) {
            $tablePK = $entity->getId();
            $securityContext = $this->container->get('security.context');
            $token = $securityContext->getToken();
            $user = $token->getUser();
            $userId = $user->getId();
            $this->logFieldUpdate($changeSets, $table, $tablePK, $userId);

        }

    }
    private function logFieldUpdate($changeSets, $table, $tablePK, $userId)
    {
        if($table=='VesselBundle\Entity\Shipdetails'){
            $table="Vessel Details";
        }
        elseif ($table=='DashboardBundle\Entity\IncidentCost'){
            $table="Incident Cost Details";
        }
        elseif ($table=='DashboardBundle\Entity\IncidentDetails'){
            $table="Incident Details";
        }
        elseif ($table=='DashboardBundle\Entity\IncidentFirstInfo'){
            $table="Incident First Info";
        }
        elseif ($table=='DashboardBundle\Entity\IncidentOperatorWeather'){
            $table="Operator Whether";
        }
        elseif ($table=='DashboardBundle\Entity\OperationattimeofIncident'){
            $table="Operation at time of Incident";
        }
        elseif ($table=='DashboardBundle\Entity\TypeofCause'){
            $table="Type of Cause";
        }
        elseif ($table=='DashboardBundle\Entity\TypeofIncident'){
            $table="Type of Inident";
        }
        $config = new Configuration();
        $pdo = new PDO("mysql:host=" . $this->dbHost . ";dbname=". $this->dbName, $this->dbUser, $this->dbPassword);
        $params = array('pdo_mysql', $this->dbUser, $this->dbPassword);
        $params['pdo'] = $pdo;
        $connection = DriverManager::getConnection($params, $config);
        $date = new \DateTime();
        foreach ($changeSets as $field => $values) {
            if (gettype($values[0]) != "object" && gettype($values[1]) != "object" && $values[0] != $values[1]) {
                $connection->insert('log_details', array('CreatedOnDateTime' => $date->format('Y-m-d H:i:s'), 'CreatedByID' => $userId, 'TableName' => $table, 'fieldName' => $field, 'TablePKID' => $tablePK, 'oldvalue' => $values[0], 'newvalue' => $values[1]));
                if($table=='Incident First Info' &&$field=''){

                }
            }
        }
        $connection->close();
        $pdo = null;  // Proper way to close a PDO connection: http://www.php.net/manual/en/pdo.connections.php
    }
}