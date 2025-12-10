<?php
class HtmlHelpers
{
    public static function tablaUsuarios(array $usuarios): string
    {
        $html  = "<table border='1' cellspacing='0' cellpadding='5'>\n";
        $html .= "  <tr>\n";
        $html .= "    <th>Usuario</th>\n";
        $html .= "    <th>\n";
        $html .= "      Nombre<br>\n";
        $html .= "      <a href=\"usuarios.php?orden=nombre&dir=asc\">ASC</a> | \n";
        $html .= "      <a href=\"usuarios.php?orden=nombre&dir=desc\">DESC</a>\n";
        $html .= "    </th>\n";
        $html .= "    <th>Email</th>\n";
        $html .= "    <th>\n";
        $html .= "      Edad<br>\n";
        $html .= "      <a href=\"usuarios.php?orden=edad&dir=asc\">ASC</a> | \n";
        $html .= "      <a href=\"usuarios.php?orden=edad&dir=desc\">DESC</a>\n";
        $html .= "    </th>\n";
        $html .= "  </tr>\n";

        foreach ($usuarios as $u) {
            $html .= "  <tr>\n";
            $html .= "    <td>{$u['user']}</td>\n";
            $html .= "    <td>{$u['nombre']}</td>\n";
            $html .= "    <td>{$u['email']}</td>\n";
            $html .= "    <td>{$u['edad']}</td>\n";
            $html .= "  </tr>\n";
        }

        $html .= "</table>\n";

        return $html;
    }
}
