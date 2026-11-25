<?php
// Escapa texto antes de mostrar no HTML, evitando XSS
function e($valor): string
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}
