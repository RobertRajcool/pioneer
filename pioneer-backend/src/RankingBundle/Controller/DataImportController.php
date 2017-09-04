<?php

namespace RankingBundle\Controller;

use RankingBundle\Entity\DataImport;
use RankingBundle\Entity\FilesFolder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use FOS\RestBundle\Controller\FOSRestController;
use JMS\Serializer\SerializationContext;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class DataImportController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
    /**
     * Add Files Action
     * @Rest\Post("/addfilesaction",name="addFiles")
     */
    public function getElementByKpiIdAction(Request $request)
    {
        $userObject=$this->getUser();
        $em = $this->getDoctrine()->getManager();
        $file=$request->files->get('datafile');
        $filedetails=json_decode($request->request->get('filedetails'),true);
        $filesofmontth=$filedetails['filesofmonth'];
        $shipIds=$filedetails['shipId'];
        $kpiId=$filedetails['kpiname'];
        $elementId=$filedetails['elementname'];
        $vesselString="";
        if(count($shipIds)!=0){
            $vesselString=implode(",",$shipIds);
        }
        else{
            $vesselString=null;
        }
        $dateObject=new \DateTime($filesofmontth);
        $lastDayOfMonth = $dateObject->modify('last day of this month');
        $folderName=date('F-Y', strtotime(date_format($lastDayOfMonth,'Y-m-d')));
        $fileName = $file->getClientOriginalName();
        $importDirectory = $this->container->getParameter('kernel.root_dir') . '/../web/uploads/excelfiles/scorecard/'.$folderName;
        $fileType = pathinfo($importDirectory . $fileName, PATHINFO_EXTENSION);
        $fileName_withoutExtension = substr($fileName, 0, -(strlen($fileType) + 1));
        $importFileName = $fileName_withoutExtension .'@'. date('Y-m-d H-i-s') .'@'. '.' . $fileType;
        if(!file_exists($importDirectory)) {
            mkdir($importDirectory, 0755, true);
            $folderobject = new FilesFolder();
            $folderobject->setFolderName($folderName);
            $em->persist($folderobject);
            $em->flush();
        }
        if ($file->move($importDirectory, $importFileName)) {
            $dateTime = date("Y-m-d H:i:s");
            $dateTimeObj = new \DateTime($dateTime);
            $dataImportObj=new DataImport();
            $dataImportObj->setUserId($em->getRepository('UserBundle:User')->findOneBy(array('id' => $userObject)));
            $folderId = $em->getRepository('RankingBundle:FilesFolder')->findOneBy(array('folderName' => $folderName));
            $dataImportObj->setFileName($importFileName);
            $dataImportObj->setMonthDetail($lastDayOfMonth);
            $dataImportObj->setDateTime($dateTimeObj);
            $dataImportObj->setFolderId($folderId);
            $dataImportObj->setVesselId($vesselString);
            $dataImportObj->setKpiDetailsId($kpiId);
            $dataImportObj->setElementDetailsId($elementId);
            $em->persist($dataImportObj);
            $em->flush();
        }
        $listoffiles=$this->listfilesAction($request,'reuseMode');
        $response = new Response($this->serialize(['status' => 'sucess','resMsg'=>'File Upload','listoffiles'=>$listoffiles]), Response::HTTP_CREATED);
        return $this->setBaseHeaders($response);
    }
    /**
     * Add Files Action
     * @Rest\Post("/listoffiles",name="listFiles")
     */
    public function listfilesAction(Request $request,$reuseMode='')
    {
        $userObject=$this->getUser();
        $em = $this->getDoctrine()->getManager();
        $listoffiles = $em->createQueryBuilder()
            ->select('c.folderName')
            ->from('RankingBundle:FilesFolder', 'c')
            ->getQuery()
            ->getResult();
        for($filecount=0;$filecount<count($listoffiles);$filecount++)
        {
            $foldername=$listoffiles[$filecount]['folderName'];
            $listoffiles_foldername = $em->createQueryBuilder()
                ->select('a.id','a.monthDetail','a.dateTime','a.fileName','b.username','c.folderName')
                ->from('RankingBundle:DataImport', 'a')
                ->leftjoin('RankingBundle:FilesFolder', 'c', 'WITH', 'c.id = a.folderId')
                ->leftjoin('UserBundle:User', 'b' ,'WITH','b.id = a.userId')
                ->where('c.folderName = :folderName')
                ->setParameter('folderName', $foldername)
                ->getQuery()
                ->getResult();
            $listoffiles[$filecount]['files']=$listoffiles_foldername;
        }
        if($reuseMode!=""){
            return $listoffiles;
        }
        $response = new Response($this->serialize(['status' => 'sucess','listoffiles'=>$listoffiles]), Response::HTTP_CREATED);
        return $this->setBaseHeaders($response);
    }
    /**
     * Set base HTTP headers.
     *
     * @param Response $response
     *
     * @return Response
     */
    public function setBaseHeaders(Response $response)
    {
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }
    /**
     * Data serializing via JMS serializer.
     *
     * @param mixed $data
     *
     * @return string JSON string
     */
    public function serialize($data)
    {
        $context = new SerializationContext();
        $context->setSerializeNull(true);

        return $this->get('jms_serializer')
            ->serialize($data, 'json', $context);
    }
}
