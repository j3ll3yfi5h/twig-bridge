<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bridge\Twig\Tests\Extension;

use Symfony\Component\Form\FormView;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Component\Form\Tests\AbstractTableLayoutTest;
use Symfony\Bridge\Twig\Tests\Extension\Fixtures\StubTranslator;
use Symfony\Bridge\Twig\Tests\Extension\Fixtures\StubFilesystemLoader;

class FormExtensionTableLayoutTest extends AbstractTableLayoutTest
{
    protected $extension;

    protected function setUp()
    {
        if (!class_exists('Symfony\Component\Locale\Locale')) {
            $this->markTestSkipped('The "Locale" component is not available');
        }

        if (!class_exists('Symfony\Component\EventDispatcher\EventDispatcher')) {
            $this->markTestSkipped('The "EventDispatcher" component is not available');
        }

        if (!class_exists('Symfony\Component\Form\Form')) {
            $this->markTestSkipped('The "Form" component is not available');
        }

        if (!class_exists('Twig_Environment')) {
            $this->markTestSkipped('Twig is not available.');
        }

        parent::setUp();

        $loader = new StubFilesystemLoader(array(
            __DIR__.'/../../../../../../src/Symfony/Bridge/Twig/Resources/views/Form',
            __DIR__,
        ));

        $this->extension = new FormExtension($this->getMock('Symfony\Component\Form\Extension\Csrf\CsrfProvider\CsrfProviderInterface'), array(
            'form_table_layout.html.twig',
            'custom_widgets.html.twig',
        ));

        $environment = new \Twig_Environment($loader);
        $environment->addExtension($this->extension);
        $environment->addExtension(new TranslationExtension(new StubTranslator()));

        $this->extension->initRuntime($environment);
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->extension = null;
    }

    protected function renderEnctype(FormView $view)
    {
        return (string)$this->extension->renderEnctype($view);
    }

    protected function renderLabel(FormView $view, $label = null, array $vars = array())
    {
        return (string)$this->extension->renderLabel($view, $label, $vars);
    }

    protected function renderErrors(FormView $view)
    {
        return (string)$this->extension->renderErrors($view);
    }

    protected function renderWidget(FormView $view, array $vars = array())
    {
        return (string)$this->extension->renderWidget($view, $vars);
    }

    protected function renderRow(FormView $view, array $vars = array())
    {
        return (string)$this->extension->renderRow($view, $vars);
    }

    protected function renderRest(FormView $view, array $vars = array())
    {
        return (string)$this->extension->renderRest($view, $vars);
    }

    protected function setTheme(FormView $view, array $themes)
    {
        $this->extension->setTheme($view, $themes);
    }
}
