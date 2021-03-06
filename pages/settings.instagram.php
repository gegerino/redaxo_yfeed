<?php

/**
 * This file is part of the YFeed package.
 *
 * @author (c) Yakamara Media GmbH & Co. KG
 * @author thomas.blum@redaxo.org
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$func = rex_request('func', 'string');

if ($func == 'update') {
    $this->setConfig(rex_post('settings', [
        ['instagram_access_token', 'string'],
    ]));

    echo \rex_view::success($this->i18n('settings_saved'));
}

$content = '';

$formElements = [];
$n = [];
$n['label'] = '<label for="consumer-token">' . $this->i18n('instagram_access_token') . '</label>';
$n['field'] = '<input class="form-control" type="text" id="consumer-token" name="settings[instagram_access_token]" value="' . htmlspecialchars($this->getConfig('instagram_access_token')) . '" />';
$formElements[] = $n;

$fragment = new \rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/form.php');

$formElements = [];
$n = [];
$n['field'] = '<a class="btn btn-abort" href="' . \rex_url::currentBackendPage() . '">' . \rex_i18n::msg('form_abort') . '</a>';
$formElements[] = $n;

$n = [];
$n['field'] = '<button class="btn btn-apply rex-form-aligned" type="submit" name="send" value="1"' . \rex::getAccesskey(\rex_i18n::msg('update'), 'apply') . '>' . \rex_i18n::msg('update') . '</button>';
$formElements[] = $n;

$fragment = new \rex_fragment();
$fragment->setVar('elements', $formElements, false);
$buttons = $fragment->parse('core/form/submit.php');

$fragment = new \rex_fragment();
$fragment->setVar('class', 'edit', false);
$fragment->setVar('title', $this->i18n('instagram_settings'), false);
$fragment->setVar('body', $content, false);
$fragment->setVar('buttons', $buttons, false);
$section = $fragment->parse('core/page/section.php');

echo '
    <form action="' . \rex_url::currentBackendPage() . '" method="post">
        <input type="hidden" name="func" value="update" />
        ' . $section . '
    </form>
';
