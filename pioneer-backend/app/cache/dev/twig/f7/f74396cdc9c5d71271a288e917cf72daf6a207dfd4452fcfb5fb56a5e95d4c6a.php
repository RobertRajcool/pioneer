<?php

/* VesselBundle:Default:index.html.twig */
class __TwigTemplate_0a99caeea4e1b5a5ce96ac075b1bc7a4d15bbf49a47366fafa54ad51c4988918 extends Twig_Template
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
        $__internal_3c8d06983e4e29ba6eccfeec2664c4789f9526857f26ce8269e3756d420d48d5 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_3c8d06983e4e29ba6eccfeec2664c4789f9526857f26ce8269e3756d420d48d5->enter($__internal_3c8d06983e4e29ba6eccfeec2664c4789f9526857f26ce8269e3756d420d48d5_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "VesselBundle:Default:index.html.twig"));

        // line 1
        echo "<html>
<body>
<div class=\"certificate-wrapper\">
    <div class=\"row-fluid\">
        <div class=\"certificates_header clearfix\">
            <div class=\"brand-title\">
                <div class=\"title\">OffHire-Reports</div>
            </div>
        </div>
<section class=\"data-row-section top-margin-space\">
    <table class=\"responsive-table certificates-table kpi_name_weightage_row\">
        <thead>
        <tr>
            <th>Vessel Name</th>
            <th>No: of incidents</th>
            <th>Off hire days</th>
            <th>Cost</th>

        </tr>
        </thead>
        <tbody>

        ";
        // line 23
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["graphDataDetails"] ?? $this->getContext($context, "graphDataDetails")));
        foreach ($context['_seq'] as $context["_key"] => $context["graphDataObject"]) {
            // line 24
            echo "            <tr>
            <td>";
            // line 25
            echo twig_escape_filter($this->env, $this->getAttribute($context["graphDataObject"], "shipName", array()), "html", null, true);
            echo "</td>
                <td> ";
            // line 26
            echo twig_escape_filter($this->env, $this->getAttribute($context["graphDataObject"], "numberofincidents", array()), "html", null, true);
            echo "</td>
                <td> ";
            // line 27
            echo twig_escape_filter($this->env, $this->getAttribute($context["graphDataObject"], "totaloffhiredays", array()), "html", null, true);
            echo "</td>
                <td> \$";
            // line 28
            echo twig_escape_filter($this->env, $this->getAttribute($context["graphDataObject"], "totalcost", array()), "html", null, true);
            echo "</td>
                </tr>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['graphDataObject'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 31
        echo "        <tr>
            <td>Total</td>
            <td> ";
        // line 33
        echo twig_escape_filter($this->env, ($context["totalincidnets"] ?? $this->getContext($context, "totalincidnets")), "html", null, true);
        echo "</td>
            <td>  ";
        // line 34
        echo twig_escape_filter($this->env, ($context["totaloffhiredays"] ?? $this->getContext($context, "totaloffhiredays")), "html", null, true);
        echo "</td>
            <td>\$";
        // line 35
        echo twig_escape_filter($this->env, ($context["totalcost"] ?? $this->getContext($context, "totalcost")), "html", null, true);
        echo "</td>
        </tr>

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
        // line 50
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
        
        $__internal_3c8d06983e4e29ba6eccfeec2664c4789f9526857f26ce8269e3756d420d48d5->leave($__internal_3c8d06983e4e29ba6eccfeec2664c4789f9526857f26ce8269e3756d420d48d5_prof);

    }

    public function getTemplateName()
    {
        return "VesselBundle:Default:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  104 => 50,  86 => 35,  82 => 34,  78 => 33,  74 => 31,  65 => 28,  61 => 27,  57 => 26,  53 => 25,  50 => 24,  46 => 23,  22 => 1,);
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
                <div class=\"title\">OffHire-Reports</div>
            </div>
        </div>
<section class=\"data-row-section top-margin-space\">
    <table class=\"responsive-table certificates-table kpi_name_weightage_row\">
        <thead>
        <tr>
            <th>Vessel Name</th>
            <th>No: of incidents</th>
            <th>Off hire days</th>
            <th>Cost</th>

        </tr>
        </thead>
        <tbody>

        {% for  graphDataObject in graphDataDetails %}
            <tr>
            <td>{{ graphDataObject.shipName}}</td>
                <td> {{graphDataObject.numberofincidents}}</td>
                <td> {{graphDataObject.totaloffhiredays}}</td>
                <td> \${{graphDataObject.totalcost}}</td>
                </tr>
        {% endfor %}
        <tr>
            <td>Total</td>
            <td> {{totalincidnets}}</td>
            <td>  {{totaloffhiredays}}</td>
            <td>\${{totalcost}}</td>
        </tr>

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

", "VesselBundle:Default:index.html.twig", "/var/www/html/pioneer/pioneer-backend/src/VesselBundle/Resources/views/Default/index.html.twig");
    }
}
