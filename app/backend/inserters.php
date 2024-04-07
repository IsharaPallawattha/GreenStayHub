<?php

function insertError(array &$session, string $error): void
{
    if (is_null($session['errors'] ?? null)) {
        $session['errors'] = array($error);
    } else {
        $session['errors'][] = $error;
    }
}

function insertWarning(array &$session, string $warning): void
{
    if (is_null($session['warnings'] ?? null)) {
        $session['warnings'] = array($warning);
    } else {
        $session['warnings'][] = $warning;
    }
}

function insertInfo(array &$session, string $info): void
{
    if (is_null($session['infos'] ?? null)) {
        $session['infos'] = array($info);
    } else {
        $session['infos'][] = $info;
    }
}
