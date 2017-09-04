<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appDevDebugProjectContainerUrlMatcher.
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appDevDebugProjectContainerUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($pathinfo);
        $context = $this->context;
        $request = $this->request;

        if (0 === strpos($pathinfo, '/_')) {
            // _wdt
            if (0 === strpos($pathinfo, '/_wdt') && preg_match('#^/_wdt/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_wdt')), array (  '_controller' => 'web_profiler.controller.profiler:toolbarAction',));
            }

            if (0 === strpos($pathinfo, '/_profiler')) {
                // _profiler_home
                if (rtrim($pathinfo, '/') === '/_profiler') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', '_profiler_home');
                    }

                    return array (  '_controller' => 'web_profiler.controller.profiler:homeAction',  '_route' => '_profiler_home',);
                }

                if (0 === strpos($pathinfo, '/_profiler/search')) {
                    // _profiler_search
                    if ($pathinfo === '/_profiler/search') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchAction',  '_route' => '_profiler_search',);
                    }

                    // _profiler_search_bar
                    if ($pathinfo === '/_profiler/search_bar') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchBarAction',  '_route' => '_profiler_search_bar',);
                    }

                }

                // _profiler_purge
                if ($pathinfo === '/_profiler/purge') {
                    return array (  '_controller' => 'web_profiler.controller.profiler:purgeAction',  '_route' => '_profiler_purge',);
                }

                // _profiler_info
                if (0 === strpos($pathinfo, '/_profiler/info') && preg_match('#^/_profiler/info/(?P<about>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_info')), array (  '_controller' => 'web_profiler.controller.profiler:infoAction',));
                }

                // _profiler_phpinfo
                if ($pathinfo === '/_profiler/phpinfo') {
                    return array (  '_controller' => 'web_profiler.controller.profiler:phpinfoAction',  '_route' => '_profiler_phpinfo',);
                }

                // _profiler_search_results
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/search/results$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_search_results')), array (  '_controller' => 'web_profiler.controller.profiler:searchResultsAction',));
                }

                // _profiler
                if (preg_match('#^/_profiler/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler')), array (  '_controller' => 'web_profiler.controller.profiler:panelAction',));
                }

                // _profiler_router
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/router$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_router')), array (  '_controller' => 'web_profiler.controller.router:panelAction',));
                }

                // _profiler_exception
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception')), array (  '_controller' => 'web_profiler.controller.exception:showAction',));
                }

                // _profiler_exception_css
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception\\.css$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception_css')), array (  '_controller' => 'web_profiler.controller.exception:cssAction',));
                }

            }

            // _twig_error_test
            if (0 === strpos($pathinfo, '/_error') && preg_match('#^/_error/(?P<code>\\d+)(?:\\.(?P<_format>[^/]++))?$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_twig_error_test')), array (  '_controller' => 'twig.controller.preview_error:previewErrorPageAction',  '_format' => 'html',));
            }

        }

        if (0 === strpos($pathinfo, '/api')) {
            if (0 === strpos($pathinfo, '/api/ranking')) {
                // addFiles
                if ($pathinfo === '/api/ranking/addfilesaction') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_addFiles;
                    }

                    return array (  '_controller' => 'RankingBundle\\Controller\\DataImportController::getElementByKpiIdAction',  '_route' => 'addFiles',);
                }
                not_addFiles:

                // listFiles
                if ($pathinfo === '/api/ranking/listoffiles') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_listFiles;
                    }

                    return array (  'reuseMode' => '',  '_controller' => 'RankingBundle\\Controller\\DataImportController::listfilesAction',  '_route' => 'listFiles',);
                }
                not_listFiles:

                if (0 === strpos($pathinfo, '/api/ranking/dataverification')) {
                    // ranking_dataverfication_index
                    if ($pathinfo === '/api/ranking/dataverification/indexaction') {
                        return array (  '_controller' => 'RankingBundle\\Controller\\DataVerficationController::indexAction',  '_route' => 'ranking_dataverfication_index',);
                    }

                    // addDataRanking
                    if ($pathinfo === '/api/ranking/dataverification/rankingIndexaction') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_addDataRanking;
                        }

                        return array (  'requestMode' => '',  '_controller' => 'RankingBundle\\Controller\\DataVerficationController::rankinDataverificationAction',  '_route' => 'addDataRanking',);
                    }
                    not_addDataRanking:

                    if (0 === strpos($pathinfo, '/api/ranking/dataverification/gotoshipWise')) {
                        // shipWiseRankingData
                        if ($pathinfo === '/api/ranking/dataverification/gotoshipWiseRankingData') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_shipWiseRankingData;
                            }

                            return array (  'requestMode' => '',  '_controller' => 'RankingBundle\\Controller\\DataVerficationController::gotoshipWiseDataRankingAction',  '_route' => 'shipWiseRankingData',);
                        }
                        not_shipWiseRankingData:

                        // shipWiseScorecardData
                        if ($pathinfo === '/api/ranking/dataverification/gotoshipWiseScorecardData') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_shipWiseScorecardData;
                            }

                            return array (  'requestMode' => '',  '_controller' => 'RankingBundle\\Controller\\DataVerficationController::gotoshipWiseDataScorecardAction',  '_route' => 'shipWiseScorecardData',);
                        }
                        not_shipWiseScorecardData:

                    }

                    // saveRankingData
                    if ($pathinfo === '/api/ranking/dataverification/saveRankingData') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_saveRankingData;
                        }

                        return array (  '_controller' => 'RankingBundle\\Controller\\DataVerficationController::saveRankingDataAction',  '_route' => 'saveRankingData',);
                    }
                    not_saveRankingData:

                    // adddataScorecard
                    if ($pathinfo === '/api/ranking/dataverification/gotoscorecardmonthdata') {
                        return array (  'requestMode' => '',  '_controller' => 'RankingBundle\\Controller\\DataVerficationController::gotoScorecardMonthDataAction',  '_route' => 'adddataScorecard',);
                    }

                    // saveScorecardData
                    if ($pathinfo === '/api/ranking/dataverification/savescorecarddata') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_saveScorecardData;
                        }

                        return array (  '_controller' => 'RankingBundle\\Controller\\DataVerficationController::addkpivaluesAction',  '_route' => 'saveScorecardData',);
                    }
                    not_saveScorecardData:

                }

                // ranking_default_index
                if (rtrim($pathinfo, '/') === '/api/ranking') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'ranking_default_index');
                    }

                    return array (  '_controller' => 'RankingBundle\\Controller\\DefaultController::indexAction',  '_route' => 'ranking_default_index',);
                }

                if (0 === strpos($pathinfo, '/api/ranking/ranking')) {
                    if (0 === strpos($pathinfo, '/api/ranking/rankingelement')) {
                        // ranking_rankingelementdetails_index
                        if ($pathinfo === '/api/ranking/rankingelement/indexaction') {
                            return array (  '_controller' => 'RankingBundle\\Controller\\RankingElementDetailsController::indexAction',  '_route' => 'ranking_rankingelementdetails_index',);
                        }

                        // selectrankingelements
                        if ($pathinfo === '/api/ranking/rankingelement/selectrankingelements') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_selectrankingelements;
                            }

                            return array (  'requestMode' => '',  '_controller' => 'RankingBundle\\Controller\\RankingElementDetailsController::selectrankingelementsAction',  '_route' => 'selectrankingelements',);
                        }
                        not_selectrankingelements:

                        // elementdetailsbykpiid
                        if ($pathinfo === '/api/ranking/rankingelement/elementdetailsbykpiid') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_elementdetailsbykpiid;
                            }

                            return array (  '_controller' => 'RankingBundle\\Controller\\RankingElementDetailsController::getElementByKpiIdAction',  '_route' => 'elementdetailsbykpiid',);
                        }
                        not_elementdetailsbykpiid:

                        // selectkpiandsymbol
                        if ($pathinfo === '/api/ranking/rankingelement/selectkpiandsymbol') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_selectkpiandsymbol;
                            }

                            return array (  'requestMode' => '',  '_controller' => 'RankingBundle\\Controller\\RankingElementDetailsController::selectkpiandsymbolIndicationAction',  '_route' => 'selectkpiandsymbol',);
                        }
                        not_selectkpiandsymbol:

                        if (0 === strpos($pathinfo, '/api/ranking/rankingelement/add')) {
                            // addSymbol
                            if ($pathinfo === '/api/ranking/rankingelement/addsymbol') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_addSymbol;
                                }

                                return array (  'requestMode' => '',  '_controller' => 'RankingBundle\\Controller\\RankingElementDetailsController::addSymbolAction',  '_route' => 'addSymbol',);
                            }
                            not_addSymbol:

                            // addElements
                            if ($pathinfo === '/api/ranking/rankingelement/addelements') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_addElements;
                                }

                                return array (  'requestMode' => '',  '_controller' => 'RankingBundle\\Controller\\RankingElementDetailsController::addElementAction',  '_route' => 'addElements',);
                            }
                            not_addElements:

                        }

                        // updateElements
                        if ($pathinfo === '/api/ranking/rankingelement/updateElement') {
                            if ($this->context->getMethod() != 'PUT') {
                                $allow[] = 'PUT';
                                goto not_updateElements;
                            }

                            return array (  'requestMode' => '',  '_controller' => 'RankingBundle\\Controller\\RankingElementDetailsController::updateElementAction',  '_route' => 'updateElements',);
                        }
                        not_updateElements:

                        // checkelementweightage
                        if ($pathinfo === '/api/ranking/rankingelement/ranking_element_checkweightage') {
                            return array (  '_controller' => 'RankingBundle\\Controller\\RankingElementDetailsController::checkelementweightageAction',  '_route' => 'checkelementweightage',);
                        }

                        // checkrankingElementName
                        if ($pathinfo === '/api/ranking/rankingelement/checkrankingelementName') {
                            return array (  '_controller' => 'RankingBundle\\Controller\\RankingElementDetailsController::checkrankingElementNameAction',  '_route' => 'checkrankingElementName',);
                        }

                        // elmentwithzeroweightage
                        if ($pathinfo === '/api/ranking/rankingelement/elmentwithzeroweightage') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_elmentwithzeroweightage;
                            }

                            return array (  'requestMode' => '',  '_controller' => 'RankingBundle\\Controller\\RankingElementDetailsController::selectallelementwithzeroweighageAction',  '_route' => 'elmentwithzeroweightage',);
                        }
                        not_elmentwithzeroweightage:

                        // selectrankingelementsbyId
                        if ($pathinfo === '/api/ranking/rankingelement/selectelementbyId') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_selectrankingelementsbyId;
                            }

                            return array (  'requestMode' => '',  '_controller' => 'RankingBundle\\Controller\\RankingElementDetailsController::selectkpiByIdAction',  '_route' => 'selectrankingelementsbyId',);
                        }
                        not_selectrankingelementsbyId:

                    }

                    if (0 === strpos($pathinfo, '/api/ranking/rankingkpi')) {
                        // ranking_rankingkpidetails_index
                        if ($pathinfo === '/api/ranking/rankingkpi/indexaction') {
                            return array (  '_controller' => 'RankingBundle\\Controller\\RankingKpiDetailsController::indexAction',  '_route' => 'ranking_rankingkpidetails_index',);
                        }

                        // addrankingKpi
                        if ($pathinfo === '/api/ranking/rankingkpi/addkpi') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_addrankingKpi;
                            }

                            return array (  '_controller' => 'RankingBundle\\Controller\\RankingKpiDetailsController::addkpiAction',  '_route' => 'addrankingKpi',);
                        }
                        not_addrankingKpi:

                        // updaterankingkpi
                        if ($pathinfo === '/api/ranking/rankingkpi/updaterankingkpi') {
                            if ($this->context->getMethod() != 'PUT') {
                                $allow[] = 'PUT';
                                goto not_updaterankingkpi;
                            }

                            return array (  '_controller' => 'RankingBundle\\Controller\\RankingKpiDetailsController::updatekpiAction',  '_route' => 'updaterankingkpi',);
                        }
                        not_updaterankingkpi:

                        if (0 === strpos($pathinfo, '/api/ranking/rankingkpi/select')) {
                            if (0 === strpos($pathinfo, '/api/ranking/rankingkpi/selectallkpi')) {
                                // selectrankingkpi
                                if ($pathinfo === '/api/ranking/rankingkpi/selectallkpi') {
                                    if ($this->context->getMethod() != 'POST') {
                                        $allow[] = 'POST';
                                        goto not_selectrankingkpi;
                                    }

                                    return array (  'requestMode' => '',  '_controller' => 'RankingBundle\\Controller\\RankingKpiDetailsController::selectallkpiAction',  '_route' => 'selectrankingkpi',);
                                }
                                not_selectrankingkpi:

                                // selectrankingkpibyfilter
                                if ($pathinfo === '/api/ranking/rankingkpi/selectallkpibyfilter') {
                                    if ($this->context->getMethod() != 'POST') {
                                        $allow[] = 'POST';
                                        goto not_selectrankingkpibyfilter;
                                    }

                                    return array (  'requestMode' => '',  '_controller' => 'RankingBundle\\Controller\\RankingKpiDetailsController::selectallusigfilterkpiAction',  '_route' => 'selectrankingkpibyfilter',);
                                }
                                not_selectrankingkpibyfilter:

                            }

                            // selectkpibyId
                            if ($pathinfo === '/api/ranking/rankingkpi/selectkpibyId') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_selectkpibyId;
                                }

                                return array (  'requestMode' => '',  '_controller' => 'RankingBundle\\Controller\\RankingKpiDetailsController::selectkpiByIdAction',  '_route' => 'selectkpibyId',);
                            }
                            not_selectkpibyId:

                        }

                        // checkkpiweightage
                        if ($pathinfo === '/api/ranking/rankingkpi/ranking_kpi_checkweightage') {
                            return array (  '_controller' => 'RankingBundle\\Controller\\RankingKpiDetailsController::checkrankingkpiweightageAction',  '_route' => 'checkkpiweightage',);
                        }

                        // checkkpiname
                        if ($pathinfo === '/api/ranking/rankingkpi/checkrankingkpiname') {
                            return array (  '_controller' => 'RankingBundle\\Controller\\RankingKpiDetailsController::checkrankingkpinameAction',  '_route' => 'checkkpiname',);
                        }

                    }

                    if (0 === strpos($pathinfo, '/api/ranking/ranking_rules')) {
                        // add_rules
                        if ($pathinfo === '/api/ranking/ranking_rules/add_rules') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_add_rules;
                            }

                            return array (  '_controller' => 'RankingBundle\\Controller\\RankingRulesDetailsController::addRulesAction',  '_route' => 'add_rules',);
                        }
                        not_add_rules:

                        // edit_rules
                        if ($pathinfo === '/api/ranking/ranking_rules/edit_rules') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_edit_rules;
                            }

                            return array (  '_controller' => 'RankingBundle\\Controller\\RankingRulesDetailsController::editRulesAction',  '_route' => 'edit_rules',);
                        }
                        not_edit_rules:

                        if (0 === strpos($pathinfo, '/api/ranking/ranking_rules/get_rules')) {
                            // get_rules_details
                            if ($pathinfo === '/api/ranking/ranking_rules/get_rules_details') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_get_rules_details;
                                }

                                return array (  '_controller' => 'RankingBundle\\Controller\\RankingRulesDetailsController::getRulesDetailsAction',  '_route' => 'get_rules_details',);
                            }
                            not_get_rules_details:

                            // get_rules
                            if ($pathinfo === '/api/ranking/ranking_rules/get_rules') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_get_rules;
                                }

                                return array (  '_controller' => 'RankingBundle\\Controller\\RankingRulesDetailsController::getRulesAction',  '_route' => 'get_rules',);
                            }
                            not_get_rules:

                        }

                    }

                }

            }

            if (0 === strpos($pathinfo, '/api/vesselbunlde')) {
                // vessel_default_index
                if (rtrim($pathinfo, '/') === '/api/vesselbunlde') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'vessel_default_index');
                    }

                    return array (  '_controller' => 'VesselBundle\\Controller\\DefaultController::indexAction',  '_format' => 'json',  '_route' => 'vessel_default_index',);
                }

                if (0 === strpos($pathinfo, '/api/vesselbunlde/secure')) {
                    // send_mail
                    if ($pathinfo === '/api/vesselbunlde/secure/sendmail') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_send_mail;
                        }

                        return array (  '_controller' => 'VesselBundle\\Controller\\MailingController::SendMailAction',  '_format' => 'json',  '_route' => 'send_mail',);
                    }
                    not_send_mail:

                    // view_mails
                    if ($pathinfo === '/api/vesselbunlde/secure/view_list') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_view_mails;
                        }

                        return array (  '_controller' => 'VesselBundle\\Controller\\MailingController::ViewmailAction',  '_format' => 'json',  '_route' => 'view_mails',);
                    }
                    not_view_mails:

                    // group_list
                    if ($pathinfo === '/api/vesselbunlde/secure/grouplist') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_group_list;
                        }

                        return array (  '_controller' => 'VesselBundle\\Controller\\MailingController::groupnameAction',  '_format' => 'json',  '_route' => 'group_list',);
                    }
                    not_group_list:

                    // list_mail
                    if ($pathinfo === '/api/vesselbunlde/secure/show_list') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_list_mail;
                        }

                        return array (  '_controller' => 'VesselBundle\\Controller\\MailingController::countListAction',  '_format' => 'json',  '_route' => 'list_mail',);
                    }
                    not_list_mail:

                    // create_group
                    if ($pathinfo === '/api/vesselbunlde/secure/createGroup') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_create_group;
                        }

                        return array (  '_controller' => 'VesselBundle\\Controller\\MailingController::CreategroupAction',  '_format' => 'json',  '_route' => 'create_group',);
                    }
                    not_create_group:

                    // group_edit
                    if ($pathinfo === '/api/vesselbunlde/secure/Groupedit') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_group_edit;
                        }

                        return array (  '_controller' => 'VesselBundle\\Controller\\MailingController::groupEditAction',  '_format' => 'json',  '_route' => 'group_edit',);
                    }
                    not_group_edit:

                    // update_group
                    if ($pathinfo === '/api/vesselbunlde/secure/update_email') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_update_group;
                        }

                        return array (  '_controller' => 'VesselBundle\\Controller\\MailingController::updateuseremailAction',  '_format' => 'json',  '_route' => 'update_group',);
                    }
                    not_update_group:

                    // groupDelete_mail
                    if ($pathinfo === '/api/vesselbunlde/secure/groupremove_email') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_groupDelete_mail;
                        }

                        return array (  '_controller' => 'VesselBundle\\Controller\\MailingController::removeEmailAction',  '_format' => 'json',  '_route' => 'groupDelete_mail',);
                    }
                    not_groupDelete_mail:

                    // Show_mails
                    if ($pathinfo === '/api/vesselbunlde/secure/mail') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_Show_mails;
                        }

                        return array (  '_controller' => 'VesselBundle\\Controller\\MailingController::mailingListAction',  '_format' => 'json',  '_route' => 'Show_mails',);
                    }
                    not_Show_mails:

                    // remove_mail
                    if ($pathinfo === '/api/vesselbunlde/secure/remove_email') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_remove_mail;
                        }

                        return array (  '_controller' => 'VesselBundle\\Controller\\MailingController::removeAction',  '_format' => 'json',  '_route' => 'remove_mail',);
                    }
                    not_remove_mail:

                    if (0 === strpos($pathinfo, '/api/vesselbunlde/secure/tras')) {
                        // trash_mails
                        if ($pathinfo === '/api/vesselbunlde/secure/trashmail') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_trash_mails;
                            }

                            return array (  '_controller' => 'VesselBundle\\Controller\\MailingController::trashmailAction',  '_format' => 'json',  '_route' => 'trash_mails',);
                        }
                        not_trash_mails:

                        // trashmail_count
                        if ($pathinfo === '/api/vesselbunlde/secure/trascount') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_trashmail_count;
                            }

                            return array (  '_controller' => 'VesselBundle\\Controller\\MailingController::trashcountAction',  '_format' => 'json',  '_route' => 'trashmail_count',);
                        }
                        not_trashmail_count:

                    }

                    // removetrash_emails
                    if ($pathinfo === '/api/vesselbunlde/secure/remove_trashemail') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_removetrash_emails;
                        }

                        return array (  '_controller' => 'VesselBundle\\Controller\\MailingController::removetrashmailAction',  '_format' => 'json',  '_route' => 'removetrash_emails',);
                    }
                    not_removetrash_emails:

                    // search_mail
                    if ($pathinfo === '/api/vesselbunlde/secure/sentmail_search') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_search_mail;
                        }

                        return array (  '_controller' => 'VesselBundle\\Controller\\MailingController::searchsentmailAction',  '_format' => 'json',  '_route' => 'search_mail',);
                    }
                    not_search_mail:

                    // search_trashmail
                    if ($pathinfo === '/api/vesselbunlde/secure/trashmail_search') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_search_trashmail;
                        }

                        return array (  '_controller' => 'VesselBundle\\Controller\\MailingController::searchtrashmailAction',  '_format' => 'json',  '_route' => 'search_trashmail',);
                    }
                    not_search_trashmail:

                    // backup
                    if ($pathinfo === '/api/vesselbunlde/secure/overallBackup') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_backup;
                        }

                        return array (  '_controller' => 'VesselBundle\\Controller\\MailingController::dbBackupAction',  '_format' => 'json',  '_route' => 'backup',);
                    }
                    not_backup:

                    // Show_backup
                    if ($pathinfo === '/api/vesselbunlde/secure/Backupshow') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_Show_backup;
                        }

                        return array (  '_controller' => 'VesselBundle\\Controller\\MailingController::backupReportShowAction',  '_format' => 'json',  '_route' => 'Show_backup',);
                    }
                    not_Show_backup:

                    // download_backup
                    if ($pathinfo === '/api/vesselbunlde/secure/download') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_download_backup;
                        }

                        return array (  '_controller' => 'VesselBundle\\Controller\\MailingController::DownloadAction',  '_format' => 'json',  '_route' => 'download_backup',);
                    }
                    not_download_backup:

                    if (0 === strpos($pathinfo, '/api/vesselbunlde/secure/all')) {
                        // get_vessel
                        if ($pathinfo === '/api/vesselbunlde/secure/allships') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_get_vessel;
                            }

                            return array (  '_controller' => 'VesselBundle\\Controller\\ReportController::AllshipsAction',  '_format' => 'json',  '_route' => 'get_vessel',);
                        }
                        not_get_vessel:

                        // get_report
                        if ($pathinfo === '/api/vesselbunlde/secure/allreport') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_get_report;
                            }

                            return array (  '_controller' => 'VesselBundle\\Controller\\ReportController::shipReportAction',  '_format' => 'json',  '_route' => 'get_report',);
                        }
                        not_get_report:

                    }

                    if (0 === strpos($pathinfo, '/api/vesselbunlde/secure/incident')) {
                        // incident_report
                        if ($pathinfo === '/api/vesselbunlde/secure/incidentreport') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_incident_report;
                            }

                            return array (  '_controller' => 'VesselBundle\\Controller\\ReportController::getIncidentAction',  '_format' => 'json',  '_route' => 'incident_report',);
                        }
                        not_incident_report:

                        // get_incidentreport
                        if ($pathinfo === '/api/vesselbunlde/secure/incidentwisereport') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_get_incidentreport;
                            }

                            return array (  'pdfmode' => ' ',  '_controller' => 'VesselBundle\\Controller\\ReportController::IncidentReportAction',  '_format' => 'json',  '_route' => 'get_incidentreport',);
                        }
                        not_get_incidentreport:

                    }

                    // severity_report
                    if ($pathinfo === '/api/vesselbunlde/secure/severitywisereport') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_severity_report;
                        }

                        return array (  '_controller' => 'VesselBundle\\Controller\\ReportController::severtyReportAction',  '_format' => 'json',  '_route' => 'severity_report',);
                    }
                    not_severity_report:

                    // openclosed_pdfreport
                    if ($pathinfo === '/api/vesselbunlde/secure/pdfopenclosed') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_openclosed_pdfreport;
                        }

                        return array (  '_controller' => 'VesselBundle\\Controller\\ReportController::openclosePdfAction',  '_format' => 'json',  '_route' => 'openclosed_pdfreport',);
                    }
                    not_openclosed_pdfreport:

                    // pdf_report
                    if ($pathinfo === '/api/vesselbunlde/secure/offhire_pdf') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_pdf_report;
                        }

                        return array (  '_controller' => 'VesselBundle\\Controller\\ReportController::PdfAction',  '_format' => 'json',  '_route' => 'pdf_report',);
                    }
                    not_pdf_report:

                    // get_incidentwisereport
                    if ($pathinfo === '/api/vesselbunlde/secure/typeofincidentreport') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_get_incidentwisereport;
                        }

                        return array (  '_controller' => 'VesselBundle\\Controller\\ReportController::incidentwiseReportAction',  '_format' => 'json',  '_route' => 'get_incidentwisereport',);
                    }
                    not_get_incidentwisereport:

                    if (0 === strpos($pathinfo, '/api/vesselbunlde/secure/pdf')) {
                        // openClosed_report
                        if ($pathinfo === '/api/vesselbunlde/secure/pdfoffhireReport') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_openClosed_report;
                            }

                            return array (  '_controller' => 'VesselBundle\\Controller\\ReportController::opencloseReportAction',  '_format' => 'json',  '_route' => 'openClosed_report',);
                        }
                        not_openClosed_report:

                        // incidentwise_pdfreport
                        if ($pathinfo === '/api/vesselbunlde/secure/pdfincidentwise') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_incidentwise_pdfreport;
                            }

                            return array (  '_controller' => 'VesselBundle\\Controller\\ReportController::pdfincidentwiseAction',  '_format' => 'json',  '_route' => 'incidentwise_pdfreport',);
                        }
                        not_incidentwise_pdfreport:

                        // vesselwise_pdfreport
                        if ($pathinfo === '/api/vesselbunlde/secure/pdfvesselreport') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_vesselwise_pdfreport;
                            }

                            return array (  '_controller' => 'VesselBundle\\Controller\\ReportController::pdfvesselwiseAction',  '_format' => 'json',  '_route' => 'vesselwise_pdfreport',);
                        }
                        not_vesselwise_pdfreport:

                    }

                    if (0 === strpos($pathinfo, '/api/vesselbunlde/secure/se')) {
                        // severity_pdfreport
                        if ($pathinfo === '/api/vesselbunlde/secure/severitywisepdf_report') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_severity_pdfreport;
                            }

                            return array (  '_controller' => 'VesselBundle\\Controller\\ReportController::pdfseveritywiseAction',  '_format' => 'json',  '_route' => 'severity_pdfreport',);
                        }
                        not_severity_pdfreport:

                        if (0 === strpos($pathinfo, '/api/vesselbunlde/secure/send')) {
                            if (0 === strpos($pathinfo, '/api/vesselbunlde/secure/sendreport')) {
                                // send_report
                                if ($pathinfo === '/api/vesselbunlde/secure/sendreport_offhire') {
                                    if ($this->context->getMethod() != 'POST') {
                                        $allow[] = 'POST';
                                        goto not_send_report;
                                    }

                                    return array (  '_controller' => 'VesselBundle\\Controller\\ReportController::sendReportoffhireAction',  '_format' => 'json',  '_route' => 'send_report',);
                                }
                                not_send_report:

                                // send_openclosedreport
                                if ($pathinfo === '/api/vesselbunlde/secure/sendreportopenclosed') {
                                    if ($this->context->getMethod() != 'POST') {
                                        $allow[] = 'POST';
                                        goto not_send_openclosedreport;
                                    }

                                    return array (  '_controller' => 'VesselBundle\\Controller\\ReportController::sendreportopenClosePdfAction',  '_format' => 'json',  '_route' => 'send_openclosedreport',);
                                }
                                not_send_openclosedreport:

                            }

                            // send_incidentwisereport
                            if ($pathinfo === '/api/vesselbunlde/secure/sendincident_report') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_send_incidentwisereport;
                                }

                                return array (  '_controller' => 'VesselBundle\\Controller\\ReportController::sendReportincidentwiseAction',  '_format' => 'json',  '_route' => 'send_incidentwisereport',);
                            }
                            not_send_incidentwisereport:

                            // send_Severityreport
                            if ($pathinfo === '/api/vesselbunlde/secure/sendSeverityReport') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_send_Severityreport;
                                }

                                return array (  '_controller' => 'VesselBundle\\Controller\\ReportController::sendReportseverityAction',  '_format' => 'json',  '_route' => 'send_Severityreport',);
                            }
                            not_send_Severityreport:

                        }

                    }

                    // CreateVessel
                    if ($pathinfo === '/api/vesselbunlde/secure/Create_Vessel') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_CreateVessel;
                        }

                        return array (  '_controller' => 'VesselBundle\\Controller\\ShipDetailsController::createShipAction',  '_format' => 'json',  '_route' => 'CreateVessel',);
                    }
                    not_CreateVessel:

                    if (0 === strpos($pathinfo, '/api/vesselbunlde/secure/Sh')) {
                        if (0 === strpos($pathinfo, '/api/vesselbunlde/secure/Show_')) {
                            // Show_Ships
                            if ($pathinfo === '/api/vesselbunlde/secure/Show_allships') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_Show_Ships;
                                }

                                return array (  '_controller' => 'VesselBundle\\Controller\\ShipDetailsController::Show_AllshipsAction',  '_format' => 'json',  '_route' => 'Show_Ships',);
                            }
                            not_Show_Ships:

                            // Showship
                            if ($pathinfo === '/api/vesselbunlde/secure/Show_ships') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_Showship;
                                }

                                return array (  '_controller' => 'VesselBundle\\Controller\\ShipDetailsController::ShowshipsAction',  '_format' => 'json',  '_route' => 'Showship',);
                            }
                            not_Showship:

                        }

                        // shipTypes
                        if ($pathinfo === '/api/vesselbunlde/secure/Ship_types') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_shipTypes;
                            }

                            return array (  '_controller' => 'VesselBundle\\Controller\\ShipDetailsController::ship_typesAction',  '_format' => 'json',  '_route' => 'shipTypes',);
                        }
                        not_shipTypes:

                        if (0 === strpos($pathinfo, '/api/vesselbunlde/secure/Show_')) {
                            // app_countries
                            if ($pathinfo === '/api/vesselbunlde/secure/Show_countries') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_app_countries;
                                }

                                return array (  '_controller' => 'VesselBundle\\Controller\\ShipDetailsController::countriesAction',  '_format' => 'json',  '_route' => 'app_countries',);
                            }
                            not_app_countries:

                            // Vessel_types
                            if ($pathinfo === '/api/vesselbunlde/secure/Show_vessel_types') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_Vessel_types;
                                }

                                return array (  '_controller' => 'VesselBundle\\Controller\\ShipDetailsController::VesselTypeAction',  '_format' => 'json',  '_route' => 'Vessel_types',);
                            }
                            not_Vessel_types:

                            // ship_status
                            if ($pathinfo === '/api/vesselbunlde/secure/Show_shipStatus') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_ship_status;
                                }

                                return array (  '_controller' => 'VesselBundle\\Controller\\ShipDetailsController::ship_statusAction',  '_format' => 'json',  '_route' => 'ship_status',);
                            }
                            not_ship_status:

                        }

                    }

                    // update_Vessel
                    if ($pathinfo === '/api/vesselbunlde/secure/update_ship') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_update_Vessel;
                        }

                        return array (  '_controller' => 'VesselBundle\\Controller\\ShipDetailsController::ship_updateAction',  '_format' => 'json',  '_route' => 'update_Vessel',);
                    }
                    not_update_Vessel:

                    // scorecard_reportGenerate
                    if ($pathinfo === '/api/vesselbunlde/secure/report_generate') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_scorecard_reportGenerate;
                        }

                        return array (  '_controller' => 'VesselBundle\\Controller\\scorecardReportController::ReportGenerateAction',  '_format' => 'json',  '_route' => 'scorecard_reportGenerate',);
                    }
                    not_scorecard_reportGenerate:

                    // ranking_reportGenerate
                    if ($pathinfo === '/api/vesselbunlde/secure/Rankingreport_generate') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_ranking_reportGenerate;
                        }

                        return array (  '_controller' => 'VesselBundle\\Controller\\scorecardReportController::RankingGenerateAction',  '_format' => 'json',  '_route' => 'ranking_reportGenerate',);
                    }
                    not_ranking_reportGenerate:

                }

            }

            if (0 === strpos($pathinfo, '/api/companyusers')) {
                // company_createuser
                if ($pathinfo === '/api/companyusers/createcompany') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_company_createuser;
                    }

                    return array (  '_controller' => 'DashboardBundle\\Controller\\CompanyUsersController::postUserAction',  '_route' => 'company_createuser',);
                }
                not_company_createuser:

                // companyusers
                if ($pathinfo === '/api/companyusers/get_companyuser') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_companyusers;
                    }

                    return array (  '_controller' => 'DashboardBundle\\Controller\\CompanyUsersController::getcompanyuserAction',  '_route' => 'companyusers',);
                }
                not_companyusers:

                // findUserbyId
                if ($pathinfo === '/api/companyusers/finduserbyId') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_findUserbyId;
                    }

                    return array (  '_controller' => 'DashboardBundle\\Controller\\CompanyUsersController::findUserbyIdAction',  '_route' => 'findUserbyId',);
                }
                not_findUserbyId:

                // changeUsrstatus
                if ($pathinfo === '/api/companyusers/changeuserstatus') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_changeUsrstatus;
                    }

                    return array (  '_controller' => 'DashboardBundle\\Controller\\CompanyUsersController::changeUserStatusAction',  '_route' => 'changeUsrstatus',);
                }
                not_changeUsrstatus:

                // updateuser
                if ($pathinfo === '/api/companyusers/updateuser') {
                    if ($this->context->getMethod() != 'PUT') {
                        $allow[] = 'PUT';
                        goto not_updateuser;
                    }

                    return array (  '_controller' => 'DashboardBundle\\Controller\\CompanyUsersController::updateAction',  '_route' => 'updateuser',);
                }
                not_updateuser:

            }

            if (0 === strpos($pathinfo, '/api/dashboard')) {
                if (0 === strpos($pathinfo, '/api/dashboard/welcome')) {
                    // dashboard_welcome
                    if ($pathinfo === '/api/dashboard/welcome') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_dashboard_welcome;
                        }

                        return array (  'reuseMode' => '',  '_controller' => 'DashboardBundle\\Controller\\DashboardController::welcomePageAction',  '_route' => 'dashboard_welcome',);
                    }
                    not_dashboard_welcome:

                    // dashboard_welcome_month
                    if ($pathinfo === '/api/dashboard/welcomedata_month') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_dashboard_welcome_month;
                        }

                        return array (  'reuseMode' => '',  '_controller' => 'DashboardBundle\\Controller\\DashboardController::monthwiseAction',  '_route' => 'dashboard_welcome_month',);
                    }
                    not_dashboard_welcome_month:

                }

                // offhiredayscost
                if ($pathinfo === '/api/dashboard/offhiredayscost') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_offhiredayscost;
                    }

                    return array (  'reuseMode' => '',  '_controller' => 'DashboardBundle\\Controller\\DashboardController::offhiredaysandCostAction',  '_route' => 'offhiredayscost',);
                }
                not_offhiredayscost:

                // typeofcausereport
                if ($pathinfo === '/api/dashboard/typeofcausereport') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_typeofcausereport;
                    }

                    return array (  'reuseMode' => '',  '_controller' => 'DashboardBundle\\Controller\\DashboardController::typeofcausereportAction',  '_route' => 'typeofcausereport',);
                }
                not_typeofcausereport:

            }

            // dashboard_default_index
            if (rtrim($pathinfo, '/') === '/api') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'dashboard_default_index');
                }

                return array (  '_controller' => 'DashboardBundle\\Controller\\DefaultController::indexAction',  '_route' => 'dashboard_default_index',);
            }

            if (0 === strpos($pathinfo, '/api/incident')) {
                if (0 === strpos($pathinfo, '/api/incident/find')) {
                    // incident_listofVessels
                    if ($pathinfo === '/api/incident/findVessels') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_incident_listofVessels;
                        }

                        return array (  'reuseMode' => '',  '_controller' => 'DashboardBundle\\Controller\\IncidentController::findallshipsAction',  '_route' => 'incident_listofVessels',);
                    }
                    not_incident_listofVessels:

                    // incident_listtypeofcaursefactorincident
                    if ($pathinfo === '/api/incident/findallincidenttime') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_incident_listtypeofcaursefactorincident;
                        }

                        return array (  'mode' => '',  '_controller' => 'DashboardBundle\\Controller\\IncidentController::findalltypeofcausefactorincidentAction',  '_route' => 'incident_listtypeofcaursefactorincident',);
                    }
                    not_incident_listtypeofcaursefactorincident:

                }

                // createnewIcident
                if ($pathinfo === '/api/incident/createnewincident') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_createnewIcident;
                    }

                    return array (  '_controller' => 'DashboardBundle\\Controller\\IncidentController::createnewIcidentAction',  '_route' => 'createnewIcident',);
                }
                not_createnewIcident:

                // addincidentDetail
                if ($pathinfo === '/api/incident/incidentDetail') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_addincidentDetail;
                    }

                    return array (  '_controller' => 'DashboardBundle\\Controller\\IncidentController::incidentDetailAction',  '_route' => 'addincidentDetail',);
                }
                not_addincidentDetail:

                if (0 === strpos($pathinfo, '/api/incident/add')) {
                    // addCostDetail
                    if ($pathinfo === '/api/incident/addCostDetails') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_addCostDetail;
                        }

                        return array (  '_controller' => 'DashboardBundle\\Controller\\IncidentController::addCostDetailAction',  '_route' => 'addCostDetail',);
                    }
                    not_addCostDetail:

                    // addOperatorWetherDetail
                    if ($pathinfo === '/api/incident/addOperatorWetherDetail') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_addOperatorWetherDetail;
                        }

                        return array (  '_controller' => 'DashboardBundle\\Controller\\IncidentController::addOperatorWetherDetailAction',  '_route' => 'addOperatorWetherDetail',);
                    }
                    not_addOperatorWetherDetail:

                    // addincident_stat_Details
                    if ($pathinfo === '/api/incident/addincident_stat_Details') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_addincident_stat_Details;
                        }

                        return array (  '_controller' => 'DashboardBundle\\Controller\\IncidentController::addstatdataDetailAction',  '_route' => 'addincident_stat_Details',);
                    }
                    not_addincident_stat_Details:

                    // addTypeofCause
                    if ($pathinfo === '/api/incident/addTypeofCause') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_addTypeofCause;
                        }

                        return array (  '_controller' => 'DashboardBundle\\Controller\\IncidentController::addTypeofCauseAction',  '_route' => 'addTypeofCause',);
                    }
                    not_addTypeofCause:

                    // addoperationattheTimeofIncident
                    if ($pathinfo === '/api/incident/addoperationattheTimeofIncident') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_addoperationattheTimeofIncident;
                        }

                        return array (  '_controller' => 'DashboardBundle\\Controller\\IncidentController::operationattheTimeofIncidentAction',  '_route' => 'addoperationattheTimeofIncident',);
                    }
                    not_addoperationattheTimeofIncident:

                }

                if (0 === strpos($pathinfo, '/api/incident/go')) {
                    // goToIncidentFirstInfo
                    if ($pathinfo === '/api/incident/goToIncidentFirstInfo') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_goToIncidentFirstInfo;
                        }

                        return array (  '_controller' => 'DashboardBundle\\Controller\\IncidentController::goToIncidentFirstInfoAction',  '_route' => 'goToIncidentFirstInfo',);
                    }
                    not_goToIncidentFirstInfo:

                    if (0 === strpos($pathinfo, '/api/incident/goto')) {
                        // gotocreateincidentDetail
                        if ($pathinfo === '/api/incident/gotocreateincidentDetail') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_gotocreateincidentDetail;
                            }

                            return array (  '_controller' => 'DashboardBundle\\Controller\\IncidentController::gotocreateincidentDetailAction',  '_route' => 'gotocreateincidentDetail',);
                        }
                        not_gotocreateincidentDetail:

                        // gotoCreateCostDetail
                        if ($pathinfo === '/api/incident/gotoCreateCostDetail') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_gotoCreateCostDetail;
                            }

                            return array (  '_controller' => 'DashboardBundle\\Controller\\IncidentController::gotoCreateCostDetailAction',  '_route' => 'gotoCreateCostDetail',);
                        }
                        not_gotoCreateCostDetail:

                        // gotocreateOperatorWhetherDetails
                        if ($pathinfo === '/api/incident/gotocreateOperatorWhetherDetails') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_gotocreateOperatorWhetherDetails;
                            }

                            return array (  '_controller' => 'DashboardBundle\\Controller\\IncidentController::gotocreateOperatorWhetherDetailsAction',  '_route' => 'gotocreateOperatorWhetherDetails',);
                        }
                        not_gotocreateOperatorWhetherDetails:

                    }

                }

                if (0 === strpos($pathinfo, '/api/incident/add')) {
                    // addfactortoIncidentmodel
                    if ($pathinfo === '/api/incident/addfactortoIncidentmodel') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_addfactortoIncidentmodel;
                        }

                        return array (  '_controller' => 'DashboardBundle\\Controller\\IncidentController::factortoIncidentmodelAction',  '_route' => 'addfactortoIncidentmodel',);
                    }
                    not_addfactortoIncidentmodel:

                    // addTypeofIncident
                    if ($pathinfo === '/api/incident/addTypeofIncident') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_addTypeofIncident;
                        }

                        return array (  '_controller' => 'DashboardBundle\\Controller\\IncidentController::addTypeofIncidentAction',  '_route' => 'addTypeofIncident',);
                    }
                    not_addTypeofIncident:

                    // addhazardtype
                    if ($pathinfo === '/api/incident/addhazardtype') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_addhazardtype;
                        }

                        return array (  '_controller' => 'DashboardBundle\\Controller\\IncidentController::addhazardtypeAction',  '_route' => 'addhazardtype',);
                    }
                    not_addhazardtype:

                    if (0 === strpos($pathinfo, '/api/incident/addTypeof')) {
                        // addTypeofInjury
                        if ($pathinfo === '/api/incident/addTypeofInjury') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_addTypeofInjury;
                            }

                            return array (  '_controller' => 'DashboardBundle\\Controller\\IncidentController::addTypeofInjuryAction',  '_route' => 'addTypeofInjury',);
                        }
                        not_addTypeofInjury:

                        // addTypeofAccident
                        if ($pathinfo === '/api/incident/addTypeofAccident') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_addTypeofAccident;
                            }

                            return array (  '_controller' => 'DashboardBundle\\Controller\\IncidentController::addTypeofAccidentAction',  '_route' => 'addTypeofAccident',);
                        }
                        not_addTypeofAccident:

                    }

                    // addPlaceofAccident
                    if ($pathinfo === '/api/incident/addPlaceofAccident') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_addPlaceofAccident;
                        }

                        return array (  '_controller' => 'DashboardBundle\\Controller\\IncidentController::addPlaceofAccidentAction',  '_route' => 'addPlaceofAccident',);
                    }
                    not_addPlaceofAccident:

                    // addBodyAreasAffected
                    if ($pathinfo === '/api/incident/addBodyAreasAffected') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_addBodyAreasAffected;
                        }

                        return array (  '_controller' => 'DashboardBundle\\Controller\\IncidentController::addBodyAreasAffectedAction',  '_route' => 'addBodyAreasAffected',);
                    }
                    not_addBodyAreasAffected:

                    if (0 === strpos($pathinfo, '/api/incident/adds')) {
                        // addshipOperation
                        if ($pathinfo === '/api/incident/addshipOperation') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_addshipOperation;
                            }

                            return array (  '_controller' => 'DashboardBundle\\Controller\\IncidentController::addshipOperationAction',  '_route' => 'addshipOperation',);
                        }
                        not_addshipOperation:

                        // addseaPollutionCategory
                        if ($pathinfo === '/api/incident/addseaPollutionCategory') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_addseaPollutionCategory;
                            }

                            return array (  '_controller' => 'DashboardBundle\\Controller\\IncidentController::addseaPollutionCategoryAction',  '_route' => 'addseaPollutionCategory',);
                        }
                        not_addseaPollutionCategory:

                    }

                    // addContainerPollutionCategory
                    if ($pathinfo === '/api/incident/addContainerPollutionCategory') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_addContainerPollutionCategory;
                        }

                        return array (  '_controller' => 'DashboardBundle\\Controller\\IncidentController::addContainerPollutionCategoryAction',  '_route' => 'addContainerPollutionCategory',);
                    }
                    not_addContainerPollutionCategory:

                }

                if (0 === strpos($pathinfo, '/api/incident/g')) {
                    // getalldropdownstatdata
                    if ($pathinfo === '/api/incident/getalldropdownstatdata') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_getalldropdownstatdata;
                        }

                        return array (  'requestMode' => '',  '_controller' => 'DashboardBundle\\Controller\\IncidentController::getalldropdownstatdataAction',  '_route' => 'getalldropdownstatdata',);
                    }
                    not_getalldropdownstatdata:

                    // gotocreateincidentstat
                    if ($pathinfo === '/api/incident/gotocreateincidentstat') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_gotocreateincidentstat;
                        }

                        return array (  '_controller' => 'DashboardBundle\\Controller\\IncidentController::gotocreateincidentstatDetailsAction',  '_route' => 'gotocreateincidentstat',);
                    }
                    not_gotocreateincidentstat:

                }

                // findalltypecause
                if ($pathinfo === '/api/incident/findalltypecause') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_findalltypecause;
                    }

                    return array (  '_controller' => 'DashboardBundle\\Controller\\IncidentController::findallTypeofCauseAction',  '_route' => 'findalltypecause',);
                }
                not_findalltypecause:

                if (0 === strpos($pathinfo, '/api/incident/change')) {
                    // changetypeofcuaseStatus
                    if ($pathinfo === '/api/incident/changetypeofcuaseStatus') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_changetypeofcuaseStatus;
                        }

                        return array (  '_controller' => 'DashboardBundle\\Controller\\IncidentController::changeTypeofCuaseStuatusAction',  '_route' => 'changetypeofcuaseStatus',);
                    }
                    not_changetypeofcuaseStatus:

                    // changeIncidentStatus
                    if ($pathinfo === '/api/incident/changeIncidentStatus') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_changeIncidentStatus;
                        }

                        return array (  '_controller' => 'DashboardBundle\\Controller\\IncidentController::changeIncidentStuatusAction',  '_route' => 'changeIncidentStatus',);
                    }
                    not_changeIncidentStatus:

                }

                if (0 === strpos($pathinfo, '/api/incident/find')) {
                    // findAllincidents
                    if ($pathinfo === '/api/incident/findincidents') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_findAllincidents;
                        }

                        return array (  '_controller' => 'DashboardBundle\\Controller\\IncidentController::findallIncidentsAction',  '_route' => 'findAllincidents',);
                    }
                    not_findAllincidents:

                    // findallincidentwithoutpaging
                    if ($pathinfo === '/api/incident/findallincidentwithoutpaging') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_findallincidentwithoutpaging;
                        }

                        return array (  '_controller' => 'DashboardBundle\\Controller\\IncidentController::findallIncidentswithoutPaginAction',  '_route' => 'findallincidentwithoutpaging',);
                    }
                    not_findallincidentwithoutpaging:

                }

            }

            if (0 === strpos($pathinfo, '/api/kpidashboard')) {
                // indexaction
                if ($pathinfo === '/api/kpidashboard/indexaction') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_indexaction;
                    }

                    return array (  '_controller' => 'DashboardBundle\\Controller\\KpiDashboardController::indexAction',  '_route' => 'indexaction',);
                }
                not_indexaction:

                // kpidashboard
                if ($pathinfo === '/api/kpidashboard/kpidashboarddata') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_kpidashboard;
                    }

                    return array (  '_controller' => 'DashboardBundle\\Controller\\KpiDashboardController::findallIncidentswithoutPaginAction',  '_route' => 'kpidashboard',);
                }
                not_kpidashboard:

                // listallkpiforship_ranking
                if ($pathinfo === '/api/kpidashboard/listallkpiforship_ranking') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_listallkpiforship_ranking;
                    }

                    return array (  '_controller' => 'DashboardBundle\\Controller\\KpiDashboardController::findInduivalshipwiseDataAction',  '_route' => 'listallkpiforship_ranking',);
                }
                not_listallkpiforship_ranking:

            }

        }

        // homepage1
        if (rtrim($pathinfo, '/') === '') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'homepage1');
            }

            return array (  '_controller' => 'UserBundle\\Controller\\DefaultController::indexAction',  '_route' => 'homepage1',);
        }

        // homepage2
        if ($pathinfo === '/test') {
            return array (  '_controller' => 'UserBundle\\Controller\\DefaultController::indexAction1',  '_route' => 'homepage2',);
        }

        if (0 === strpos($pathinfo, '/authencation')) {
            // user_welcome
            if ($pathinfo === '/authencation/welcome') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_user_welcome;
                }

                return array (  '_controller' => 'UserBundle\\Controller\\UserController::WelcomeAction',  '_route' => 'user_welcome',);
            }
            not_user_welcome:

            // userLogout
            if ($pathinfo === '/authencation/logout') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_userLogout;
                }

                return array (  '_controller' => 'UserBundle\\Controller\\UserController::logoutAction',  '_route' => 'userLogout',);
            }
            not_userLogout:

            // createuser
            if ($pathinfo === '/authencation/createcompany') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_createuser;
                }

                return array (  '_controller' => 'UserBundle\\Controller\\UserController::postUserAction',  '_route' => 'createuser',);
            }
            not_createuser:

            // requestpassword
            if ($pathinfo === '/authencation/forgot_password') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_requestpassword;
                }

                return array (  '_controller' => 'UserBundle\\Controller\\UserController::requestNewPaaswordAction',  '_route' => 'requestpassword',);
            }
            not_requestpassword:

            // log_details
            if ($pathinfo === '/authencation/log_details') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_log_details;
                }

                return array (  '_controller' => 'UserBundle\\Controller\\UserController::logdetailsAction',  '_route' => 'log_details',);
            }
            not_log_details:

            // userAuthencation
            if ($pathinfo === '/authencation/check_user') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_userAuthencation;
                }

                return array (  '_controller' => 'UserBundle\\Controller\\UserController::loginAction',  '_route' => 'userAuthencation',);
            }
            not_userAuthencation:

            // companyuserlist
            if ($pathinfo === '/authencation/get_companyuser') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_companyuserlist;
                }

                return array (  '_controller' => 'UserBundle\\Controller\\UserController::getAction',  '_route' => 'companyuserlist',);
            }
            not_companyuserlist:

        }

        // fos_js_routing_js
        if (0 === strpos($pathinfo, '/js/routing') && preg_match('#^/js/routing(?:\\.(?P<_format>js|json))?$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'fos_js_routing_js')), array (  '_controller' => 'fos_js_routing.controller:indexAction',  '_format' => 'js',));
        }

        if (0 === strpos($pathinfo, '/userbundle')) {
            if (0 === strpos($pathinfo, '/userbundle/log')) {
                if (0 === strpos($pathinfo, '/userbundle/login')) {
                    // fos_user_security_login
                    if ($pathinfo === '/userbundle/login') {
                        if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                            goto not_fos_user_security_login;
                        }

                        return array (  '_controller' => 'FOS\\UserBundle\\Controller\\SecurityController::loginAction',  '_route' => 'fos_user_security_login',);
                    }
                    not_fos_user_security_login:

                    // fos_user_security_check
                    if ($pathinfo === '/userbundle/login_check') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_fos_user_security_check;
                        }

                        return array (  '_controller' => 'FOS\\UserBundle\\Controller\\SecurityController::checkAction',  '_route' => 'fos_user_security_check',);
                    }
                    not_fos_user_security_check:

                }

                // fos_user_security_logout
                if ($pathinfo === '/userbundle/logout') {
                    if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                        goto not_fos_user_security_logout;
                    }

                    return array (  '_controller' => 'FOS\\UserBundle\\Controller\\SecurityController::logoutAction',  '_route' => 'fos_user_security_logout',);
                }
                not_fos_user_security_logout:

            }

            if (0 === strpos($pathinfo, '/userbundle/profile')) {
                // fos_user_profile_show
                if (rtrim($pathinfo, '/') === '/userbundle/profile') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_fos_user_profile_show;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'fos_user_profile_show');
                    }

                    return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ProfileController::showAction',  '_route' => 'fos_user_profile_show',);
                }
                not_fos_user_profile_show:

                // fos_user_profile_edit
                if ($pathinfo === '/userbundle/profile/edit') {
                    if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                        goto not_fos_user_profile_edit;
                    }

                    return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ProfileController::editAction',  '_route' => 'fos_user_profile_edit',);
                }
                not_fos_user_profile_edit:

            }

            if (0 === strpos($pathinfo, '/userbundle/re')) {
                if (0 === strpos($pathinfo, '/userbundle/register')) {
                    // fos_user_registration_register
                    if (rtrim($pathinfo, '/') === '/userbundle/register') {
                        if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                            goto not_fos_user_registration_register;
                        }

                        if (substr($pathinfo, -1) !== '/') {
                            return $this->redirect($pathinfo.'/', 'fos_user_registration_register');
                        }

                        return array (  '_controller' => 'FOS\\UserBundle\\Controller\\RegistrationController::registerAction',  '_route' => 'fos_user_registration_register',);
                    }
                    not_fos_user_registration_register:

                    if (0 === strpos($pathinfo, '/userbundle/register/c')) {
                        // fos_user_registration_check_email
                        if ($pathinfo === '/userbundle/register/check-email') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_fos_user_registration_check_email;
                            }

                            return array (  '_controller' => 'FOS\\UserBundle\\Controller\\RegistrationController::checkEmailAction',  '_route' => 'fos_user_registration_check_email',);
                        }
                        not_fos_user_registration_check_email:

                        if (0 === strpos($pathinfo, '/userbundle/register/confirm')) {
                            // fos_user_registration_confirm
                            if (preg_match('#^/userbundle/register/confirm/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_fos_user_registration_confirm;
                                }

                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'fos_user_registration_confirm')), array (  '_controller' => 'FOS\\UserBundle\\Controller\\RegistrationController::confirmAction',));
                            }
                            not_fos_user_registration_confirm:

                            // fos_user_registration_confirmed
                            if ($pathinfo === '/userbundle/register/confirmed') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_fos_user_registration_confirmed;
                                }

                                return array (  '_controller' => 'FOS\\UserBundle\\Controller\\RegistrationController::confirmedAction',  '_route' => 'fos_user_registration_confirmed',);
                            }
                            not_fos_user_registration_confirmed:

                        }

                    }

                }

                if (0 === strpos($pathinfo, '/userbundle/resetting')) {
                    // fos_user_resetting_request
                    if ($pathinfo === '/userbundle/resetting/request') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_fos_user_resetting_request;
                        }

                        return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ResettingController::requestAction',  '_route' => 'fos_user_resetting_request',);
                    }
                    not_fos_user_resetting_request:

                    // fos_user_resetting_send_email
                    if ($pathinfo === '/userbundle/resetting/send-email') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_fos_user_resetting_send_email;
                        }

                        return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ResettingController::sendEmailAction',  '_route' => 'fos_user_resetting_send_email',);
                    }
                    not_fos_user_resetting_send_email:

                    // fos_user_resetting_check_email
                    if ($pathinfo === '/userbundle/resetting/check-email') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_fos_user_resetting_check_email;
                        }

                        return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ResettingController::checkEmailAction',  '_route' => 'fos_user_resetting_check_email',);
                    }
                    not_fos_user_resetting_check_email:

                    // fos_user_resetting_reset
                    if (0 === strpos($pathinfo, '/userbundle/resetting/reset') && preg_match('#^/userbundle/resetting/reset/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                            goto not_fos_user_resetting_reset;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'fos_user_resetting_reset')), array (  '_controller' => 'FOS\\UserBundle\\Controller\\ResettingController::resetAction',));
                    }
                    not_fos_user_resetting_reset:

                }

            }

            // fos_user_change_password
            if ($pathinfo === '/userbundle/profile/change-password') {
                if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                    goto not_fos_user_change_password;
                }

                return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ChangePasswordController::changePasswordAction',  '_route' => 'fos_user_change_password',);
            }
            not_fos_user_change_password:

        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
