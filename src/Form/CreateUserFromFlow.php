<?php

namespace App\Form;

use Craue\FormFlowBundle\Form\FormFlow;
use Craue\FormFlowBundle\Form\FormFlowInterface;
use App\Form\CreateUserStep1Type;
use App\Form\CreateUserStep2Type;

class CreateUserFromFlow extends FormFlow {

	
	protected $allowDynamicStepNavigation = true;
	
	protected function loadStepsConfig() {
        return [
			[
				'label' => 'email',
				'form_type' => CreateUserStep1Type::class,
			],
			[
				'label' => 'password',
				'form_type' => CreateUserStep2Type::class,
				//'skip' =>true,			
			],
			[
				'label' => 'confirmation',
			],
			
		];    

	
	}

}