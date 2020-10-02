<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */

$cakeDescription = 'Customer Project';
$session = $this->getRequest()->getSession();
?>
<!DOCTYPE html>
<html lang="EN">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet">

    <?= $this->Html->css(['normalize.min', 'milligram.min', 'cake', 'custom']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <nav class="top-nav">
        <div class="top-nav-title">
            <a href="<?= $this->Url->build('/tests') ?>"><span>Customer</span>Project</a>
        </div>
        <div class="top-nav-links">
            <?php if($session->read('Auth.role') === "docent"): ?>
                <?= $this->Html->link('Users', ['controller' => 'Users', 'action' => 'index']); ?>
                <?= $this->Html->link('Groups', ['controller' => 'Groups', 'action' => 'index']); ?>
                <?= $this->Html->link('Tests', ['controller' => 'Tests', 'action' => 'index']); ?>
                <?= $this->Html->link('Logout', ['controller' => 'Users', 'action' => 'logout']); ?>
            <?php elseif ($session->read('Auth.role') === "student"): ?>
                <?= $this->Html->link('Logout', ['controller' => 'Users', 'action' => 'logout']); ?>
            <?php endif; ?>
        </div>
    </nav>
    <main class="main">
        <div class="container">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div>
    </main>
    <footer style="text-align: center; margin-top: 20px;">
      <small>Build by: Niels Kolkman (<a href="https://www.linkedin.com/in/niels-kolkman-519552173/" target="_blank">LinkedIn</a>) & Jeroen de Nijs (<a href="https://jeroendn.nl" target="_blank">jeroendn.nl</a>)</small>
    </footer>
</body>
</html>
