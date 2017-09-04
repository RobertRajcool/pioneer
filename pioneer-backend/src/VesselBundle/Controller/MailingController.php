<?php
namespace VesselBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\Form\FormInterface;
use VesselBundle\Entity\Shipdetails;
use UserBundle\Util\CommonFunctions;
use JMS\Serializer\SerializationContext;
use VesselBundle\Entity\mailingdetails;
use VesselBundle\Entity\EmailGroup;
use VesselBundle\Entity\EmailUsers;
use VesselBundle\Entity\Backupreport;

/**
 * MailingController.
 * @Route("/secure")
 */
class MailingController extends Controller
{


    /**
     * @Rest\Post("/sendmail",name="send_mail")
     */
    public function SendMailAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $requestContent=json_decode($request->getContent(),true);
        $companyDetails=$requestContent['currentuser'];
        $userLoginmailid=$companyDetails['email'];
        $sendermailId=$companyDetails['email'];
        $mailDetails=$requestContent['mailList'];
        $Editorvalues=$requestContent['Editorcontent'];
        //$bodyContent=strip_tags($Editorvalues ,'<br>');
        $usermail=$mailDetails['userEmail'];
        $subject=$mailDetails['subject'];
        $today = date("Y-m-d H:i:s");
        $today_date = date_create($today);

        $mailidarray = array();
        if (filter_var($usermail, FILTER_VALIDATE_EMAIL)) {
            array_push($mailidarray, $usermail);
            $mailer = $this->container->get('mailer');
            $message = \Swift_Message::newInstance()
                ->setFrom($userLoginmailid)
                ->setTo($usermail)
                ->setSubject($subject)
                ->setBody($Editorvalues, "text/html");
            //$message->attach(\Swift_Attachment::fromPath()->setFilename());
            $mailer->send($message);
        } else {
            $findmail = $em->createQueryBuilder()
                ->select('a.useremailid')
                ->from('VesselBundle:EmailUsers', 'a')
                ->join('VesselBundle:EmailGroup', 'b', 'WITH', 'b.id = a.groupid')
                ->where('b.groupname = :groupname')
                ->ORwhere('a.useremailid = :mailid')
                ->setParameter('groupname', $usermail)
                ->setParameter('mailid', $usermail)
                ->getQuery()
                ->getResult();
            for ($i = 0; $i < count($findmail); $i++) {
                $mailer = $this->container->get('mailer');
                $message = \Swift_Message::newInstance()
                    ->setFrom('starshipping123@gmail.com')
                    ->setTo($findmail[$i]['useremailid'])
                    ->setSubject($subject)
                    ->setBody($Editorvalues, "text/html");
                //$message->attach(\Swift_Attachment::fromPath()->setFilename());
                $mailer->send($message);
                array_push($mailidarray, $findmail[$i]['useremailid']);
            }

        }
        $bodyContent=strip_tags($Editorvalues );
        $em = $this->getDoctrine()->getManager();
        $mail=new mailingdetails();
        $mail->setuserEmail($usermail);
        $mail->setDate($today_date);
        $mail->setsenderMail($sendermailId);
        $mail->setSubject($subject);
        $mail->setTextcontent($bodyContent);
        $mail->setStatus(1);
        $mail->setSendername($companyDetails['username']);
        $mail->setCompanyName($companyDetails['company_id']);
        $em->persist($mail);
        $em->flush();

        $response = new JsonResponse();
        $response = new Response($this->serialize(['savedmsg' => 'mail has beeen send!']), Response::HTTP_CREATED);
        return $this->setBaseHeaders($response);
        return $response;

    }

    /**
     * @Rest\post("/view_list",name="view_mails")
     */

    public function ViewmailAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $mail_id=$request->request->get('viewobject');
        $List = $em->createQueryBuilder()
            ->select('a.sendername', 'a.id','a.subject','a.Date','a.userEmail','a.status','a.senderMail','a.Textcontent')
            ->from('VesselBundle:mailingdetails', 'a')
            ->where('a.id = :id')
            ->setParameter('id',$mail_id)
            ->getQuery();
        $maildetails = $List->getResult();
        $response = new JsonResponse($maildetails);
        return $response;

    }


    /**
     * @Rest\Get("/grouplist",name="group_list")
     */
    public function groupnameAction(){
        $em=$this->getDoctrine()->getManager();
        $List = $em->createQueryBuilder()
            ->select('a.groupname','a.id')
            ->from('VesselBundle:EmailGroup', 'a')
            ->getQuery();
        $maildetails = $List->getResult();
        $response = new JsonResponse($maildetails);
        return $response;
    }

    /**
     * @Rest\Post("/show_list",name="list_mail")
     */

    public function countListAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $requestContent=json_decode($request->getContent(),true);
        $companydetails=$requestContent['currentuser'];
        $username=$companydetails['username'];
        $statusfield=1;
        $List = $em->createQueryBuilder()
            ->select('a.sendername', 'a.id','a.subject','a.Date','a.userEmail','a.status')
            ->from('VesselBundle:mailingdetails', 'a')
            ->where('a.status = :status')
            ->andwhere('a.sendername = :username')
            ->setParameter('status',$statusfield)
            ->setparameter('username',$username)
            ->getQuery();
        $maildetails = $List->getResult();
        $mailCount=Count($maildetails);
        $response = new JsonResponse($mailCount);
        return $response;

    }

    /**
     * @Rest\Post("/createGroup",name="create_group")
     */
    public function CreategroupAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $requestContent=json_decode($request->getContent(),true);
        $companyDetails=$requestContent['currentuser'];
        $groupDetails=$requestContent['group'];
        $UserMail=$requestContent['emailobject'];
        $companyname=$companyDetails['company_id'];
        $groupName=$groupDetails['groupname'];
        //$Email=$groupDetails['email'];

        $emailgroup=new EmailGroup();
        $emailgroup->setGroupname($groupName);
        $emailgroup->setcompanyname($companyname);
        $emailgroup->setGroupstatus(1);
        $em->persist($emailgroup);
        $em->flush();
        $groupid= $emailgroup->getId();

        for($i=0;$i<count($UserMail);$i++)
        {
            $emailusers=new EmailUsers();
            $groupid = $em->getRepository('VesselBundle:EmailGroup')->findOneBy(array('id'=>$groupid));
            $emailusers->setGroupid($groupid);
            $emailusers->setUseremailid($UserMail[$i]);
            $em->persist($emailusers);
            $em->flush();
        }

        $groupmessage= $groupName. ' group has been created successfully!';
        $response = new JsonResponse();
        $response = new Response($this->serialize(['savedmsg' => $groupmessage]), Response::HTTP_CREATED);
        return $this->setBaseHeaders($response);
        return $response;


    }

    /**
     * @Rest\Post("/Groupedit",name="group_edit")
     */
    public function groupEditAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $requestContent=json_decode($request->getContent(),true);
        $group_id=$requestContent['groupidobject'];
        $groupobject = $em->getRepository('VesselBundle:EmailGroup')->findOneBy(array('id'=>$group_id));
        $groupName=$groupobject->getGroupname();
        $groupEmailid = $em->createQueryBuilder()
            ->select('b.useremailid')
            ->from('VesselBundle:EmailGroup','c')
            ->join('VesselBundle:EmailUsers','b', 'WITH', 'b.groupid = c.id')
            ->where('c.id = :id')
            ->setParameter('id',$group_id)
            ->getQuery();
        $groupmailDetails = $groupEmailid->getResult();
        $response = new JsonResponse();
        $response->setData(array('groupemail' => $groupmailDetails,'group'=>$groupName,'groupid'=>$group_id));
        return $response;


    }

    /**
     * @Rest\Post("/update_email",name="update_group")
     */

    public function updateuseremailAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $requestContent=json_decode($request->getContent(),true);
        $groupid=$requestContent['groupid'];
        $listofusermail=$requestContent['addemail'];
        $groupdetail=$requestContent['group'];
        $groupName=$groupdetail['groupname'];
        $groupuserid = $em->createQueryBuilder()
            ->select('c.useremailid')
            ->from('VesselBundle:EmailUsers','c')
            ->where('c.groupid = :groupid')
            ->setParameter('groupid',$groupid)
            ->getQuery()
            ->getResult();
        $checkemailarray=array();
        for($k=0;$k<count($groupuserid);$k++)
        {
            array_push($checkemailarray,$groupuserid[$k]['useremailid']);
        }
        for($j=0;$j<count($checkemailarray);$j++)
        {
            if ($checkemailarray[$j]==$listofusermail)
            {
                $qb = $em->createQueryBuilder()
                    ->delete('VesselBundle:EmailUsers', 'd')
                    ->where('d.useremailid = :useremailid')
                    ->setParameter(':useremailid', $checkemailarray[$j])
                    ->getQuery()
                    ->getResult();
            }
        }
        for($j=0;$j<count($listofusermail);$j++)
        {
            if (!in_array($listofusermail[$j], $checkemailarray))
            {
                $emailusers=new EmailUsers();
                $emailref = $em->getRepository('VesselBundle:EmailGroup')->findOneBy(array('id'=>$groupid));
                $emailusers->setGroupid($emailref);
                $emailusers->setUseremailid($listofusermail[$j]);
                $em->persist($emailusers);
                $em->flush();
            }
        }

        $entity = $em->getRepository('VesselBundle:EmailGroup')->find($groupid);
        $entity->setGroupname($groupName);
        $em->flush();
        $groupeditstatus=$groupName.' group has been updated successfully';
        $response = new JsonResponse();
        $response->setData(array('groupupdatemsg' => $groupeditstatus));
        return $response;


    }


    /**
     * @Rest\Post("/groupremove_email",name="groupDelete_mail")
     */

    public function removeEmailAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $requestContent=json_decode($request->getContent(),true);
        $groupmail_id=$requestContent['mailobject'];
        $userid=$requestContent['idobject'];
        $mailid=$groupmail_id['useremailid'];
        $query = $em->createQueryBuilder()
            ->delete()
            ->from('VesselBundle:EmailUsers','a')
            ->where('a.useremailid = :id')
            ->andwhere('a.groupid =:userid')
            ->setParameter('id',$mailid )
            ->setParameter('userid',  $userid)
            ->getQuery();
        $removegroupmail = $query->getResult();
        $response = new JsonResponse();
        return $response;

    }

    /**
     * @Rest\post("/mail",name="Show_mails")
     */

    public function mailingListAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $requestContent=json_decode($request->getContent(),true);
        $companydetails=$requestContent['currentuser'];
        $username=$companydetails['username'];
        $pageNumber=$request->request->get('pageNumber');
        $records_per_page=$request->request->get('recordsperPage');
        $statusfield=1;
        $mailList = $em->createQueryBuilder()
            ->select('a.sendername', 'a.id','a.subject','a.Date','a.userEmail','a.status')
            ->from('VesselBundle:mailingdetails', 'a')
            ->where('a.status = :status')
            ->andwhere('a.sendername = :username')
            ->setParameter('status',$statusfield)
            ->setparameter('username',$username)
            ->getQuery();
        $mailDetails = $mailList->getResult();
        $total_records = count($mailDetails);
        $last_page = ceil($total_records / $records_per_page);
        $previous_page = $pageNumber > 1 ? $pageNumber - 1 : 1;
        $next_page = $pageNumber < $last_page ? $pageNumber + 1 : $last_page;
        $listActiveRecords = $em->createQueryBuilder()
            ->select('a.sendername', 'a.id','a.subject','a.Date','a.userEmail','a.status')
            ->from('VesselBundle:mailingdetails', 'a')
            ->orderBy('a.id','DESC')
            ->where('a.status = :status')
            ->andwhere('a.sendername = :username')
            ->setParameter('status',$statusfield)
            ->setparameter('username',$username)
            ->setMaxResults($records_per_page)
            ->setFirstResult(($pageNumber - 1) * $records_per_page)
            ->getQuery()
            ->getResult();
        $response = new Response($this->serialize(['mailList' => $listActiveRecords,
            'totalRecords'=>$total_records,'last_page' => $last_page,
            'previous_page' => $previous_page, 'current_page' => (int)$pageNumber,
            'next_page' => $next_page]), Response::HTTP_CREATED);
        return $this->setBaseHeaders($response);

    }


    /**
     * @Rest\Post("/remove_email",name="remove_mail")
     */
    public function removeAction(Request $request)
    {
        $requestContent = json_decode($request->getContent(), true);
        $removeDetails = $requestContent['removeobject'];
        $count=Count($removeDetails);
        $status=0;
        for ($mailid = 0; $mailid < $removeDetails; $mailid++){
            if($mailid==$count){
                $sentmessagestatus=$count. 'mail has been moved to trash';
                $response = new Response($this->serialize(['sentmsg' => $sentmessagestatus]), Response::HTTP_CREATED);
                return $this->setBaseHeaders($response);
            }
            $em = $this->getDoctrine()->getManager();
            $query = $em->createQueryBuilder()
                ->update('VesselBundle:mailingdetails','a')
                ->set('a.status', 0)
                ->where('a.id = :mailid')
                ->setParameter('mailid',$removeDetails[$mailid] )
                ->getQuery();


            $mailDetails = $query->getResult();;
        }
        $sentmessagestatus=$count. 'mail has been moved to trash';
        $response = new JsonResponse();
        $response = new Response($this->serialize(['sentmsg' => $sentmessagestatus]), Response::HTTP_CREATED);
        return $this->setBaseHeaders($response);
        return $response;

    }
    /**
     * @Rest\post("/trashmail",name="trash_mails")
     */

    public function trashmailAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $requestContent=json_decode($request->getContent(),true);
        $companydetails=$requestContent['currentuser'];
        $username=$companydetails['username'];
        $pageNumber=$request->request->get('pageNumber');
        $records_per_page=$request->request->get('recordsperPage');
        $statusfield=0;
        $trashList = $em->createQueryBuilder()
            ->select('a.sendername', 'a.id','a.subject','a.Date','a.userEmail','a.status')
            ->from('VesselBundle:mailingdetails', 'a')
            ->where('a.status = :status')
            ->andwhere('a.sendername = :username')
            ->setParameter('status',$statusfield)
            ->setparameter('username',$username)
            ->getQuery();
        $trashDetails = $trashList->getResult();
        $total_records = count($trashDetails);
        $last_page = ceil($total_records / $records_per_page);
        $previous_page = $pageNumber > 1 ? $pageNumber - 1 : 1;
        $next_page = $pageNumber < $last_page ? $pageNumber + 1 : $last_page;
        $listofTrashRecords = $em->createQueryBuilder()
            ->select('a.sendername', 'a.id','a.subject','a.Date','a.userEmail','a.status')
            ->from('VesselBundle:mailingdetails', 'a')
            ->orderBy('a.id','DESC')
            ->where('a.status = :status')
            ->andwhere('a.sendername = :username')
            ->setParameter('status',$statusfield)
            ->setparameter('username',$username)
            ->setMaxResults($records_per_page)
            ->setFirstResult(($pageNumber - 1) * $records_per_page)
            ->getQuery()
            ->getResult();

        $response = new Response($this->serialize(['trashList' => $listofTrashRecords,
            'totalRecords'=>$total_records,'last_page' => $last_page,
            'previous_page' => $previous_page, 'current_page' => (int)$pageNumber,
            'next_page' => $next_page]), Response::HTTP_CREATED);
        return $this->setBaseHeaders($response);

    }

    /**
     * @Rest\post("/trascount",name="trashmail_count")
     */

    public function trashcountAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $requestContent=json_decode($request->getContent(),true);
        $companydetails=$requestContent['currentuser'];
        $username=$companydetails['username'];
        $statusfield=0;
        $trashListcount = $em->createQueryBuilder()
            ->select('a.sendername', 'a.id','a.subject','a.Date','a.userEmail','a.status')
            ->from('VesselBundle:mailingdetails', 'a')
            ->where('a.status = :status')
            ->andwhere('a.sendername = :username')
            ->setParameter('status',$statusfield)
            ->setparameter('username',$username)
            ->getQuery();
        $trashDetails = $trashListcount->getResult();
        $trashCount=Count($trashDetails);
        $response = new JsonResponse($trashCount);
        return $response;

    }

    /**
     * @Rest\Post("/remove_trashemail",name="removetrash_emails")
     */
    public function removetrashmailAction(Request $request)
    {
        $requestContent = json_decode($request->getContent(), true);
        $trashmailDetails = $requestContent['removeobject'];
        $count=Count($trashmailDetails);
        // $status=0;
        for ($mailid = 0; $mailid < $trashmailDetails; $mailid++){
            if($mailid==$count){
                $trashmessagestatus=$count. 'mail has been deleted from trash';
                $response = new Response($this->serialize(['statusmsg' => $trashmessagestatus]), Response::HTTP_CREATED);
                return $this->setBaseHeaders($response);
            }
            $em = $this->getDoctrine()->getManager();
            $query = $em->createQueryBuilder()
                ->delete()
                ->from('VesselBundle:mailingdetails','a')
                ->where('a.id = :id')
                ->setParameter('id',$trashmailDetails[$mailid] )
                ->getQuery();
            $trashlistDetails = $query->getResult();
        }
        $trashmessagestatus=$count. 'mail has been deleted from trash';
        $response = new JsonResponse();
        $response = new Response($this->serialize(['statusmsg' => $trashmessagestatus]), Response::HTTP_CREATED);
        return $this->setBaseHeaders($response);
        return $response;

    }

    /**
     * @Rest\Post("/sentmail_search",name="search_mail")
     */

    public function searchsentmailAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $searchkey=$request->request->get('searchSentmail');
        $statusfield=1;
        $searchmailcount = $em->createQueryBuilder()
            ->select('a.sendername', 'a.id','a.subject','a.Date','a.userEmail','a.status')
            ->from('VesselBundle:mailingdetails', 'a')
            ->where('a.status = :status')
            ->andwhere('a.userEmail = :usermail')
            ->setParameter('status',$statusfield)
            ->setparameter('usermail',$searchkey)
            ->getQuery();
        $sentmailListDetails = $searchmailcount->getResult();
        if( $sentmailListDetails==0){
            $response = new Response($this->serialize(['statusmsg' => 'No messages matched your search.']), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);

        }
        $response = new JsonResponse($sentmailListDetails);
        return $response;


    }


    /**
     * @Rest\Post("/trashmail_search",name="search_trashmail")
     */

    public function searchtrashmailAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $searchtrashkey = $request->request->get('searchtrashmail');
        $pageNumber = $request->request->get('pageNumber');
        $records_per_page = $request->request->get('recordsperPage');
        $statusfield = 0;
        $trashhmailcount = $em->createQueryBuilder()
            ->select('a.sendername', 'a.id', 'a.subject', 'a.Date', 'a.userEmail', 'a.status')
            ->from('VesselBundle:mailingdetails', 'a')
            ->where('a.status = :status')
            ->andwhere('a.userEmail = :usermail')
            ->setParameter('status', $statusfield)
            ->setparameter('usermail', $searchtrashkey)
            ->getQuery();
        $trashmailListDetails = $trashhmailcount->getResult();

        $response = new JsonResponse($trashmailListDetails);
        return $response;
    }

    /**
     * @Rest\Post("/overallBackup",name="backup")
     */


    public function dbBackupAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $username = $request->request->get('username');
        $date = new \DateTime();
        $connection = $em->getConnection();
        $listoftables = array();
        $sm = $connection->getSchemaManager();
        $refConn = new \ReflectionObject($connection);
        $refParams = $refConn->getProperty('_params');
        $refParams->setAccessible('public');
        $params = $refParams->getValue($connection);

        $filelocation = $this->container->getParameter('kernel.root_dir') . '/../web/sqlfiles';
        if (!is_dir($filelocation)) {
            mkdir($filelocation,0777, true);
        }
        $outfile_filepath = $filelocation . '/' . $params['dbname'] . '.sql';
        if (file_exists($outfile_filepath)) {
            unlink($outfile_filepath);
        }
        $command = 'mysqldump -u' . $params['user'] . ' -p' . $params['password'] . ' ' . $params['dbname'] . '  > ' . $outfile_filepath;


        system($command);


        $content = file_get_contents($outfile_filepath);
        $response = new Response();
        $response->setContent($content);
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=\"" . $params['dbname'] . ".sql\"");

        $backup = new Backupreport();
        $backup->setfileName($outfile_filepath);
        $backup->setusername($username);
        $backup->setDateTime($date);
        $em->persist($backup);
        $em->flush();
        return $response;

    }

    /**
     * @Rest\Post("/Backupshow",name="Show_backup")
     */

    public function backupReportShowAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $pageNumber=$request->request->get('pageNumber');
        $records_per_page=$request->request->get('recordsperPage');
        $backupReport = $em->createQueryBuilder()
            ->select('a.fileName,a.dateTime, a.username,a.id')
            ->from('VesselBundle:Backupreport', 'a')
            ->getQuery();
        $backupListDetails = $backupReport->getResult();
        $total_records = count($backupListDetails);
        $last_page = ceil($total_records / $records_per_page);
        $previous_page = $pageNumber > 1 ? $pageNumber - 1 : 1;
        $next_page = $pageNumber < $last_page ? $pageNumber + 1 : $last_page;
        $listActiveRecords = $em->createQueryBuilder()
            ->select('a.fileName,a.dateTime, a.username,a.id')
            ->from('VesselBundle:Backupreport', 'a')
            ->orderBy('a.id','DESC')
            ->setMaxResults($records_per_page)
            ->setFirstResult(($pageNumber - 1) * $records_per_page)
            ->getQuery()
            ->getResult();
        $response = new Response($this->serialize(['List' => $listActiveRecords,
            'totalRecords'=>$total_records,'last_page' => $last_page,
            'previous_page' => $previous_page, 'current_page' => (int)$pageNumber,
            'next_page' => $next_page]), Response::HTTP_CREATED);
        return $this->setBaseHeaders($response);

    }

    /*  $response = new JsonResponse($backupListDetails);
      return $response;
  }*/

    /**
     * @Rest\Post("/download",name="download_backup")
     */

    public function DownloadAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $fileName_fromDb = $request->request->get('backupid');
        //$fileName_fromDb = $backupreport->getFileName();
        $directoryLocation = $this->container->getParameter('kernel.root_dir') . '/../web/sqlfiles';
        $filePath = $fileName_fromDb;
        $content = file_get_contents($filePath);
        $response = new Response();
        $response->setContent($content);
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=\"" . 'Database_backup'. ".sql\"");
        return $response;

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
