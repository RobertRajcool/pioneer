<?php

/* VesselBundle:Default:openclosedpdf.html.twig */
class __TwigTemplate_85e8a2f5d22c717b05696c8cd744f7c9078c6650f99b8ce25e0691aa1b81b96f extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_b77a4466902a4b2c8710c51ab7233b48fa4ee877b477dadbc831b6021ddd8db6 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_b77a4466902a4b2c8710c51ab7233b48fa4ee877b477dadbc831b6021ddd8db6->enter($__internal_b77a4466902a4b2c8710c51ab7233b48fa4ee877b477dadbc831b6021ddd8db6_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "VesselBundle:Default:openclosedpdf.html.twig"));

        // line 1
        echo "<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"utf-8\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <title>Shipping</title>
    <!-- Bootstrap -->


    <link rel=\"stylesheet\" href=\"";
        // line 11
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("customcss/bootstrap.min.css"), "html", null, true);
        echo "\" />
    <link rel=\"stylesheet\" href=\"";
        // line 12
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("customcss/pdf.css"), "html", null, true);
        echo "\" />
    <link rel=\"stylesheet\" href=\"";
        // line 13
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("customcss/app.css"), "html", null, true);
        echo "\" />
    <link rel=\"stylesheet\" href=\"";
        // line 14
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("customcss/ss-standard.css"), "html", null, true);
        echo "\" />
    <link rel=\"stylesheet\" href=\"";
        // line 15
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("customcss/font-awesome.css"), "html", null, true);
        echo "\" />
    <link rel=\"stylesheet\" href=\"";
        // line 16
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("customcss/font-awesome.min.css"), "html", null, true);
        echo "\" />




   ";
        // line 24
        echo "    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src=\"customjs/jquery.min.js\"></script>
    <script src=\"customjs/angular.min.js\"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src=\"customjs/bootstrap.min.js\"></script>

</head>
<body>
<div class=\"certificate-wrapper\">
    <div class=\"row-fluid\">
        <div class=\"certificates_header clearfix\">
            <div class=\"brand-title\">
                <div class=\"title\" style=\"color:red \">Open/Closed Reports</div>
            </div>
        </div>
        <section class=\"data-row-section top-margin-space\">
            <table class=\"responsive-table certificates-table kpi_name_weightage_row\">
                <thead>
                <tr>
                    <th>Vessels</th>
                    <th>No.of Incidents</th>
                    <th>Total closed</th>
                    <th>Total Pending</th>


                </tr>
                </thead>
                <tbody>
                ";
        // line 52
        $context["j"] = 0;
        // line 53
        echo "                ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["shipDetails"] ?? $this->getContext($context, "shipDetails")));
        foreach ($context['_seq'] as $context["_key"] => $context["incidentstatusData"]) {
            // line 54
            echo "                    <tr>
                    <td>";
            // line 55
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["incidentstatusData"], 0, array(), "array"), "shipName", array(), "array"), "html", null, true);
            echo "</td>
                        <td>";
            // line 56
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["incidentCount"] ?? $this->getContext($context, "incidentCount")), ($context["j"] ?? $this->getContext($context, "j")), array(), "array"), 0, array(), "array"), "incidentCount", array(), "array"), "html", null, true);
            echo "</td>
                        <td>";
            // line 57
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["incidentClosed"] ?? $this->getContext($context, "incidentClosed")), ($context["j"] ?? $this->getContext($context, "j")), array(), "array"), 0, array(), "array"), "incidentClosed", array(), "array"), "html", null, true);
            echo "</td>
                        <td>";
            // line 58
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute(($context["incidentOpened"] ?? $this->getContext($context, "incidentOpened")), ($context["j"] ?? $this->getContext($context, "j")), array(), "array"), 0, array(), "array"), "incidentOpened", array(), "array"), "html", null, true);
            echo "</td>
                        </tr>
                    ";
            // line 60
            $context["j"] = (($context["j"] ?? $this->getContext($context, "j")) + 1);
            // line 61
            echo "                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['incidentstatusData'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 62
        echo "
                </tbody>
            </table>
        </section>
        <section class=\"data-row-section top-margin-space\">
            <table class=\"responsive-table certificates-table\">
                <thead>
                <tr>
                    <th class=\"branding-colours thead-title-two-row no-td-right-border\"></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><img src=\"/phantomjs/listofgraph/";
        // line 75
        echo twig_escape_filter($this->env, ($context["imageSource"] ?? $this->getContext($context, "imageSource")), "html", null, true);
        echo "\" alt=\"Loader Image\"/></td>
                </tr>
                </tbody>
            </table>
        </section>
    </div>
</div>
</body>
</html>

";
        
        $__internal_b77a4466902a4b2c8710c51ab7233b48fa4ee877b477dadbc831b6021ddd8db6->leave($__internal_b77a4466902a4b2c8710c51ab7233b48fa4ee877b477dadbc831b6021ddd8db6_prof);

    }

    public function getTemplateName()
    {
        return "VesselBundle:Default:openclosedpdf.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  142 => 75,  127 => 62,  121 => 61,  119 => 60,  114 => 58,  110 => 57,  106 => 56,  102 => 55,  99 => 54,  94 => 53,  92 => 52,  62 => 24,  54 => 16,  50 => 15,  46 => 14,  42 => 13,  38 => 12,  34 => 11,  22 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"utf-8\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <title>Shipping</title>
    <!-- Bootstrap -->


    <link rel=\"stylesheet\" href=\"{{ asset('customcss/bootstrap.min.css') }}\" />
    <link rel=\"stylesheet\" href=\"{{ asset('customcss/pdf.css') }}\" />
    <link rel=\"stylesheet\" href=\"{{ asset('customcss/app.css') }}\" />
    <link rel=\"stylesheet\" href=\"{{ asset('customcss/ss-standard.css') }}\" />
    <link rel=\"stylesheet\" href=\"{{ asset('customcss/font-awesome.css') }}\" />
    <link rel=\"stylesheet\" href=\"{{ asset('customcss/font-awesome.min.css') }}\" />




   {# <link href=\"customcss/ss-standard.css\" rel=\"stylesheet\">
    <link href=\"customcss/font-awesome.css\" rel=\"stylesheet\">
    <link href=\"customcss/font-awesome.min.css\" rel=\"stylesheet\">#}
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src=\"customjs/jquery.min.js\"></script>
    <script src=\"customjs/angular.min.js\"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src=\"customjs/bootstrap.min.js\"></script>

</head>
<body>
<div class=\"certificate-wrapper\">
    <div class=\"row-fluid\">
        <div class=\"certificates_header clearfix\">
            <div class=\"brand-title\">
                <div class=\"title\" style=\"color:red \">Open/Closed Reports</div>
            </div>
        </div>
        <section class=\"data-row-section top-margin-space\">
            <table class=\"responsive-table certificates-table kpi_name_weightage_row\">
                <thead>
                <tr>
                    <th>Vessels</th>
                    <th>No.of Incidents</th>
                    <th>Total closed</th>
                    <th>Total Pending</th>


                </tr>
                </thead>
                <tbody>
                {% set j=0 %}
                {% for incidentstatusData  in shipDetails %}
                    <tr>
                    <td>{{incidentstatusData[0]['shipName']}}</td>
                        <td>{{incidentCount[j][0]['incidentCount']}}</td>
                        <td>{{incidentClosed[j][0]['incidentClosed']}}</td>
                        <td>{{incidentOpened[j][0]['incidentOpened']}}</td>
                        </tr>
                    {% set j=j+1 %}
                {% endfor %}

                </tbody>
            </table>
        </section>
        <section class=\"data-row-section top-margin-space\">
            <table class=\"responsive-table certificates-table\">
                <thead>
                <tr>
                    <th class=\"branding-colours thead-title-two-row no-td-right-border\"></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><img src=\"/phantomjs/listofgraph/{{ imageSource }}\" alt=\"Loader Image\"/></td>
                </tr>
                </tbody>
            </table>
        </section>
    </div>
</div>
</body>
</html>

", "VesselBundle:Default:openclosedpdf.html.twig", "/var/www/html/pioneer/pioneer-backend/src/VesselBundle/Resources/views/Default/openclosedpdf.html.twig");
    }
}
