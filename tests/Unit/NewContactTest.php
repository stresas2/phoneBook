<?php

namespace App\Tests;

use App\Entity\Contacts;
use App\Form\ContactTypes;
use Symfony\Component\Form\Test\TypeTestCase;

class NewContactTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = [
            'Name' => 'Lukas',
            'Number' => '864668717',
        ];

        $form = $this->factory->create(ContactTypes::class);

        $object = new Contacts();

        $object->setName($formData['Name']);
        $object->setNumber($formData['Number']);

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());

        $this->assertEquals($object, $form->getData());

        $view     = $form->createView();
        $children = $view->children;
        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }


    }
}