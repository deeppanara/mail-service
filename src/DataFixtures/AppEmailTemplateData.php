<?php

namespace App\DataFixtures;

use App\Entity\EmailTemplate;
use App\Repository\EmailGroupRepository;
use App\Repository\EmailTagRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\AsciiSlugger;

class AppEmailTemplateData extends Fixture implements DependentFixtureInterface
{
    /**
     * @var EmailGroupRepository
     */
    private $emailGroupRepository;
    /**
     * @var EmailTagRepository
     */
    private $emailTagRepository;

    public function __construct(EmailGroupRepository $emailGroupRepository, EmailTagRepository $emailTagRepository)
    {
        $this->emailGroupRepository = $emailGroupRepository;
        $this->emailTagRepository = $emailTagRepository;
    }

    public function load(ObjectManager $em)
    {
        $emilGroups = $this->emailGroupRepository->findAll();
        $emilTages = $this->emailTagRepository->findAll();

        // check whether file is present
        $path = __DIR__.'/EmailTemplate/email_template.csv';

        if (false !== ($reader = new \EasyCSV\Reader($path))) {
            $reader->setDelimiter(';');
            while ($row = $reader->getRow()) {

                $emailtemplate = new EmailTemplate();
                $slugger = new AsciiSlugger();
                $emilGroup = $emilGroups[array_rand($emilGroups)];
                [$header, $footer] = $this->getHeaderFooterHtml();

                $slug = $slugger->slug($emilGroup->getName() .' '. $row['name']);

                $emailtemplate->setIdentifier($slug);
                $emailtemplate->setEmailGroup($emilGroup);
                $emailtemplate->setName($row['name']);
                $emailtemplate->setSubject($row['subject']);
                $emailtemplate->setBodyHtml($header.file_get_contents(__DIR__.'/EmailTemplate/en/html/'. $row['html_file_name']).$footer);
                $emailtemplate->setSenderEmail("cosmos@dom.com");
                $emailtemplate->setSenderName("Cosmos Dom");
                $emailtemplate->setStatus(1);

                $em->persist($emailtemplate);
                $em->flush();
            }
        }

    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return class-string[]
     */
    public function getDependencies()
    {
        return [
            AppEmailGroupData::class
        ];
    }

    public function getHeaderFooterHtml()
    {
        $bodyHtml[] = <<<EOD
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width">
        <title>Title</title>
        <style>
            @import url('https://fonts.googleapis.com/css?family=Roboto:300,400,700');
            *, *::before, *::after{box-sizing: inherit}
            body{box-sizing:border-box;color:#474747;font-family: 'Roboto', sans-serif;font-size:18px;margin:0;padding:0;min-width:100%;width:100%!important}
            body, td, input, textarea, select{font-family: 'Roboto', sans-serif}
            table{border-spacing:0;border-collapse:collapse}
            table, tr, td{padding:0}
            img{border:0}
            a{display:inline-block;font-family: 'Roboto', sans-serif;}
            .bold{font-weight:bold}
            .header-bg{background:#1c5379;box-shadow:0px 5px 4.75px 0.25px rgba(0, 0, 0, 0.25);position:relative}
            .header .menu-link a{color:#fff;font-weight:700;font-size:18px;text-decoration:none;text-shadow:2px 2px 2px rgba(71, 71, 71, 0.3)}
            .logo{display:inline-block}
            .logo img{max-width:100%}
            .menu-icon{display:none;width:18px;margin-top:12px}
            .menu-icon span{background:#fff;width:100%;height:2px;margin-bottom:3px;display:block;box-shadow: 0 2px 2px rgba(0,0,0,.25)}
            .hero-bg{background: url({{ (hero_image is defined and hero_image ? hero_image : site_url~'/bundles/faffrontend/images/email-hero-bg.png') }}) no-repeat}
            .welcome-content{background:rgba(71,71,71,.9)}
            .welcome-content h1{margin:0;font-size:30px;font-weight:700;color:#fff;font-variant: small-caps;letter-spacing:4px;padding:20px 0 10px}
            .welcome-content p{color:#fff;font-size:18px;font-weight:700;letter-spacing:4px;margin-top:0;line-height:30px}
            .orange-button{background:#e5901a;border:0;font-variant:small-caps;letter-spacing:1.8px;padding:17px 20px 20px;font-size:18px;color:#fff;font-weight:700;text-decoration:none;display:block;text-shadow: 2px 2px 2px rgba(71, 71, 71, 0.50);border-radius:3px;box-shadow:2px 3px 5px rgba(0, 0, 0, 0.24);text-align:center}
            .main-content, .main-content p{font-weight:300;font-size:18px;}
            .main-content p{margin-top:0}
            .main-content .section-title{font-size:20px;font-weight:700;color:#474747;margin:0;padding:0 0 18px;text-transform:uppercase;letter-spacing:1.8px;}
            .footer{background:#003558}
            .footer-top-clm-1{font-size:18px;font-weight:300;color:#fff}
            .footer-top-clm-1 a{font-weight:700;text-decoration:underline;color:#f4a101}
            .footer-top-clm-2{font-size:20px;font-weight:300;color:#fff}
            .footer-top-clm-2 .orange-button{margin-top:22px}
            .footer-bottom{background:#1c5379;width:100%;color:#fff;font-size:14px;font-weight:300}
            .footer-title{text-transform:uppercase;padding-bottom:10px;border-bottom:1px solid #fff;color:#fff;font-size:14px;font-weight:300;margin:0;letter-spacing:1px}
            .footer-links-tbl a{color:#fff;text-decoration:none;font-size:14px;font-weight:300}
            .links-column{padding:26px 0}
            .links-column a{display:inline-block;vertical-align:top;}
            .footer-links-tbl .quick-links .links-column a{width:32%}
            .about-us .links-column a{width:49%}
            .in-icon{background-image:url({{site_url}}/bundles/faffrontend/images/linkedin-icon.png)}
            .fb-icon{background-image:url({{site_url}}/bundles/faffrontend/images/fb-icon.png)}
            .gp-icon{background-image:url({{site_url}}/bundles/faffrontend/images/gplus-icon.png)}
            .tw-icon{background-image:url({{site_url}}/bundles/faffrontend/images/twitter-icon.png)}
            .yt-icon{background-image:url({{site_url}}/bundles/faffrontend/images/utube-icon.png)}
            .social-icons{display:block;margin-top:29px}
            .social-icons a{display:inline-block;width:24px;height:24px;font-size:0;background-size:24px 24px;background-repeat:no-repeat;vertical-align:top}
            .footer-copyright{border-top:1px solid #fff;padding:30px 0}
            .footer-copyright td{color:#fff;font-weight:300;font-size:14px}
            .company-name img{display:inline-block;vertical-align:middle;margin-right:5px}
            .footer-logo .logo{vertical-align:middle;width:71px;height:37px;margin-left:18px}
            .menu-wrapper{position:relative}
            #hidden-checkbox{position:absolute;right:30px;top:24px;margin:0;width:18px;height:15px;opacity:0}
            #menu{display:none}
            .data-columns{width:100%;background:#000;border-collapse:separate;border-spacing:1px;}
            .data-columns td{padding:10px;width:25%;background:#fff}
            .order-list td{padding:10px}

            @media screen and (max-width:639px) {
                .container{width:100%}
                .header-bg{height:65px}
                .header{width:100%}
                .header .menu-link{display:none}
                .menu-icon{display:block;float:right;margin-right:30px;}
                .logo{width:59px;height:31px;margin-left:30px;margin-top:3px}
                .hero-bg{width:100%;height:320px}
                .welcome-content h1{font-size:18px;padding:15px 10px;letter-spacing:3px}
                .welcome-content p{font-size:14px;letter-spacing:2px;line-height:normal;}
                .welcome-buttons{width:91%;margin-bottom:20px}
                .welcome-btn-space{width:20px}
                .orange-button{font-size:16px;padding:8px 10px 10px}
                .main-content{padding:10px}
                .main-content, .main-content p{font-size:14px}
                .main-content .section-title{font-size:18px;padding:15px 0 9px;}
                .footer-top{margin:20px auto}
                .footer-top-clm-1, .footer-top-clm-2{width:49.7%;font-size:14px;padding:5px 10px}
                .footer-bottom-spacing{padding:22px 10px 0}
                .quick-links{display:none}
                .about-us, .follow-us{width:100%;display:block;text-align:center}
                .about-us .links-column a{width:46%;text-align:right;padding-right:8px}
                .about-us .links-column a:nth-child(2n){text-align:left;padding-right:0;padding-left:8px}
                .social-icons{margin:30px 0 24px}
                .social-icons a{width:43px;height:43px;background-size:43px 43px}
                .footer-copyright{padding:20px 0}
                .footer-copyright td{font-size:12px}
                .company-name img{width:20px;height:20px}
                .footer-logo .logo{width:56px;height:29px;margin-left:7px}
                #hidden-checkbox:checked ~ #menu{display:block}
                #menu .mob-menu-link{display:block;color:#fff;text-decoration:none;font-size:14px;padding:10px 30px;border-top:1px solid #d3d3d3;text-align:center;font-weight:700}
                .data-columns td{display:block;width:100%;border-bottom:1px solid #000}
                .data-columns td:last-child{border-bottom:0}
            }

            @media screen and (min-width:640px) and (max-width:1023px) {
                .container{width:640px}
                .header-bg{height:75px}
                .header{width:546px}
                .logo{width:80px;height:42px}
                .hero-bg{width:100%;height:480px}
                .welcome-buttons{width:94%;margin-bottom:20px}
                .welcome-btn-space{width:20px}
                .main-content{padding:20px}
                .footer-top{width:600px;margin:28px auto}
                .footer-top-clm-1{width:290px;padding:36px 14px 36px 0}
                .footer-top-clm-2{width:290px;padding:36px 0 36px 14px}
                .footer-bottom-spacing{padding:47px 10px 0}
                .quick-links{display:none}
                .about-us, .follow-us{width:50%}
                .follow-us{text-align:right}
                .social-icons a{width:43px;height:43px;background-size:43px 43px}
                #hidden-checkbox{display:none}
            }

            @media screen and (min-width:1024px) {
                .container{width:1024px;margin:0 auto;}
                .header-bg{height:100px}
                .header{width:693px}
                .logo{width:96px;height:50px}
                .hero-bg{width:100%;height:480px;padding-bottom:30px}
                .welcome-content{width:690px}
                .welcome-buttons{width:91%;margin-bottom:30px}
                .welcome-btn-space{width:30px}
                .main-content{padding:20px 197px}
                .footer-top{width:630px;margin:28px auto}
                .footer-top-clm-1{width:310px;padding:36px 14px 36px 0}
                .footer-top-clm-2{width:310px;padding:36px 0 36px 14px}
                .footer-bottom-spacing{padding:70px 32px 0}
                .quick-links{width:495px}
                .about-us{width:330px}
                .follow-us{width:135px}
                #hidden-checkbox{display:none}
            }
        </style>
    </head>

    <body>
        <table class="container" align="center">
            <tr class="header-bg">
                <td class="menu-wrapper">
                    <table class="header" align="center">
                        <tr>
                            <td height="65">
                                <a href="javascript:void(0);" class="logo"><img src="{{site_url}}/bundles/faffrontend/images/logo.png"></a>
                                <a href="javascript:void(0);" class="menu-icon">
                                    <span></span><span></span><span></span>
                                </a>
                            </td>
                            <td align="center" class="menu-link"><a href="{{ url_account_dashboard }}">My<br />Dashboard</a></td>
                            <td align="center" class="menu-link"><a href="{{ url_messages }}">Messages</a></td>
                            <td align="center" class="menu-link"><a href="{{ url_notifications }}">Notifications</a></td>
                        </tr>
                    </table>
                    <input id="hidden-checkbox" type="checkbox">
                    <div id="menu">
                        <a href="{{ url_account_dashboard }}" class="mob-menu-link">My Dashboard</a>
                        <a href="{{ url_messages }}" class="mob-menu-link">Messages</a>
                        <a href="{{ url_notifications }}" class="mob-menu-link">Notifications</a>
                    </div>
                </td>
            </tr>
             <tr>
                <td>
                
EOD;
$bodyHtml[] = <<<EOD

                </td>
            </tr>
            <tr>
                <td class="footer">
                    <table class="footer-top" align="center">
                        <tr>
                            <td class="footer-top-clm-1" align="center">
                                You have received this email because you are special to us!<br /><br />
                                If you don’t wish to receive these emails, configure your account email setting <a href="javascript:void(0);">here</a>.
                            </td>
                            <td width="2" bgcolor="#fff"></td>
                            <td class="footer-top-clm-2" align="center">
                                Thank you for choosing our services!
                                <a href="javascript:void(0);" class="orange-button">Post an AD!</a>
                            </td>
                        </tr>
                    </table>

                    <table class="footer-bottom" align="center">
                        <tr>
                            <td class="footer-bottom-spacing">
                                <table width="100%">
                                    <tr>
                                        <td valign="top">
                                            <table width="100%" class="footer-links-tbl">
                                                <tr>
                                                    <td class="quick-links" valign="top">
                                                        <h3 class="footer-title">Quick links</h3>
                                                        <div class="links-column">
                                                            {% if quick_links is defined and quick_links|length %}
                                                                {% for quickLink in quick_links %}
                                                                    <a href="{{ quickLink['source_url'] }}">{{ quickLink['name'] }}</a>
                                                                {% endfor %}
                                                            {% endif %}
                                                        </div>
                                                    </td>
                                                    <td class="about-us" valign="top">
                                                        <h3 class="footer-title">About us</h3>
                                                        <div class="links-column">
                                                            {% if static_pages is defined and static_pages|length %}
                                                                {% for staticPage in static_pages %}
                                                                    <a href="{{ staticPage['url'] }}">{{ staticPage['title'] }}</a>
                                                                {% endfor %}
                                                            {% endif %}
                                                        </div>
                                                    </td>
                                                    <td class="follow-us" valign="top">
                                                        <h3 class="footer-title">Follow us</h3>
                                                        <div class="social-icons">
                                                            <a href="javascript:void(0);" class="in-icon">Linkedin</a>
                                                            <a href="javascript:void(0);" class="fb-icon">Facebook</a>
                                                            <a href="javascript:void(0);" class="gp-icon">Google plus</a>
                                                            <a href="javascript:void(0);" class="tw-icon">Twitter</a>
                                                            <a href="javascript:void(0);" class="yt-icon">Youtube</a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="footer-copyright">
                                            <table width="100%" class="">
                                                <tr>
                                                    <td class="company-name">
                                                        <img src="{{site_url}}/bundles/faffrontend/images/copyright-icon.png"> 2017. Company name
                                                    </td>
                                                    <td align="right" class="footer-logo">
                                                        Powered by <a href="javascript:void(0);" class="logo"><img src="{{site_url}}/bundles/faffrontend/images/logo.png"></a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>
EOD;

        return $bodyHtml;
    }
}
