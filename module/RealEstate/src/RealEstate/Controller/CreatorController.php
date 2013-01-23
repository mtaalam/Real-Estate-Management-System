<?php

namespace RealEstate\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CreatorController extends AbstractActionController {

	public function houseAction() {

		$form = new \RealEstate\Form\HouseForm();
		$form->get('submit')->setAttribute('label', 'Add');

		$request = $this->getRequest();
		if ($request->isPost()) {
			$house = new \RealEstate\Entity\House();
			$houseFilter = new \RealEstate\Form\Filter\HouseFilter($this->getServiceLocator()->get('db'));
			
			$form->setInputFilter($houseFilter->getInputFilter());
			$form->setData($request->getPost());
			
			if ($form->isValid()) {
				$data = $request->getPost();
				
				var_dump($data);
				
				$house->setCost($data->cost);
				
				$this->getEntityManager()->persist($house);
				$this->getEntityManager()->flush();

				var_dump($house);
			}
		}
		return new ViewModel(array(
					'form' => $form
				));
	}

	/**
	 * Entity manager instance
	 *           
	 * @var Doctrine\ORM\EntityManager
	 */
	protected $em;

	/**
	 * Returns an instance of the Doctrine entity manager loaded from the service 
	 * locator
	 * 
	 * @return Doctrine\ORM\EntityManager
	 */
	public function getEntityManager() {
		if (null === $this->em) {
			$this->em = $this->getServiceLocator()
					->get('doctrine.entitymanager.orm_default');
		}
		return $this->em;
	}

}
