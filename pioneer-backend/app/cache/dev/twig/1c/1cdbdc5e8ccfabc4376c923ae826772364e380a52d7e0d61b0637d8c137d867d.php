<?php

/* VesselBundle:Default:incidentwisepdf.html.twig */
class __TwigTemplate_2b1f614c1493eb3b5c8d9f0e71fa8be9c7c8ffe287d6da0685881e11789ee421 extends Twig_Template
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
        $__internal_7c02c44917612709e94bd7e70df42aac1b3c8b6135f27c394ab3d0400a54a034 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_7c02c44917612709e94bd7e70df42aac1b3c8b6135f27c394ab3d0400a54a034->enter($__internal_7c02c44917612709e94bd7e70df42aac1b3c8b6135f27c394ab3d0400a54a034_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "VesselBundle:Default:incidentwisepdf.html.twig"));

        // line 1
        echo "<html>
<body>
<div class=\"certificate-wrapper\">
    <div class=\"row-fluid\">
        <div class=\"certificates_header clearfix\">
            <div class=\"brand-title\">
                <div class=\"title\">incident wise Reports</div>
            </div>
        </div>
        <section class=\"data-row-section top-margin-space\">
            <table class=\"responsive-table certificates-table kpi_name_weightage_row\">
                <thead>
                <tr>
                    <th>Incident Name</th>
                    <th>year</th>
                    <th>Total</th>


                </tr>
                </thead>
                <tbody>
                ";
        // line 22
        $context["j"] = 0;
        // line 23
        echo "                ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["incidentName"] ?? $this->getContext($context, "incidentName")));
        foreach ($context['_seq'] as $context["_key"] => $context["incidentwisestatusData"]) {
            // line 24
            echo "                    <tr>
                        <td>";
            // line 25
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["incidentwisestatusData"], 0, array(), "array"), "incidentName", array(), "array"), "html", null, true);
            echo "</td>
                        <td>";
            // line 26
            echo twig_escape_filter($this->env, ($context["currentYear"] ?? $this->getContext($context, "currentYear")), "html", null, true);
            echo "</td>
                        <td>";
            // line 27
            echo twig_escape_filter($this->env, $this->getAttribute(($context["incidentvalues"] ?? $this->getContext($context, "incidentvalues")), ($context["j"] ?? $this->getContext($context, "j")), array(), "array"), "html", null, true);
            echo "</td>

                    </tr>
                    ";
            // line 30
            $context["j"] = (($context["j"] ?? $this->getContext($context, "j")) + 1);
            // line 31
            echo "                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['incidentwisestatusData'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 32
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
        // line 45
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
        
        $__internal_7c02c44917612709e94bd7e70df42aac1b3c8b6135f27c394ab3d0400a54a034->leave($__internal_7c02c44917612709e94bd7e70df42aac1b3c8b6135f27c394ab3d0400a54a034_prof);

    }

    public function getTemplateName()
    {
        return "VesselBundle:Default:incidentwisepdf.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  92 => 45,  77 => 32,  71 => 31,  69 => 30,  63 => 27,  59 => 26,  55 => 25,  52 => 24,  47 => 23,  45 => 22,  22 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<html>
<body>
<div class=\"certificate-wrapper\">
    <div class=\"row-fluid\">
        <div class=\"certificates_header clearfix\">
            <div class=\"brand-title\">
                <div class=\"title\">incident wise Reports</div>
            </div>
        </div>
        <section class=\"data-row-section top-margin-space\">
            <table class=\"responsive-table certificates-table kpi_name_weightage_row\">
                <thead>
                <tr>
                    <th>Incident Name</th>
                    <th>year</th>
                    <th>Total</th>


                </tr>
                </thead>
                <tbody>
                {% set j=0 %}
                {% for incidentwisestatusData  in incidentName %}
                    <tr>
                        <td>{{incidentwisestatusData[0]['incidentName']}}</td>
                        <td>{{currentYear}}</td>
                        <td>{{incidentvalues[j]}}</td>

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

", "VesselBundle:Default:incidentwisepdf.html.twig", "/var/www/html/pioneer/pioneer-backend/src/VesselBundle/Resources/views/Default/incidentwisepdf.html.twig");
    }
}
