<?php

Template::setText('admin_texte_active', 'active');

if ($_SESSION['admin'] === False) {
    base::setRoute('home', 'index', TRUE);
}

if (end($url) == 'save') {
    Texte::saveTexte($_POST);
    base::setRoute('user', 'admin/texte', TRUE);
}

if (end($url) == 'new') {
    Texte::insertText($_POST);
    base::setRoute('user', 'admin/texte', TRUE);
}

if (isset($url['3'])) {
    template::setText('texte', texte::loadAdminTexte($url['3']));
    template::setText('sprache', $url['3']);
} else {
    template::setText('texte', texte::loadAdminTexte($session->get('language')));
    template::setText('sprache', $session->get('language'));
}


if (in_array('install', $url)) {
    texte::activateLanguage(end($url));
    base::setRoute('user', 'admin/texte', TRUE);
}

if (in_array('delete', $url) && in_array('text', $url)) {
    texte::deleteText(end($url));
    base::setRoute('user', 'admin/texte', TRUE);
}

if (in_array('delete', $url) && in_array('lang', $url)) {
    texte::deleteLang(end($url));
    base::setRoute('user', 'admin/texte', TRUE);
}

template::setText('texte_inaktiv', texte::getSprachen());

?>
