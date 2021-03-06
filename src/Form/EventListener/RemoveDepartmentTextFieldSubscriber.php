<?php

namespace KejawenLab\Application\SemartHris\Form\EventListener;

use KejawenLab\Application\SemartHris\Component\Company\Repository\DepartmentRepositoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@kejawenlab.com>
 */
final class RemoveDepartmentTextFieldSubscriber implements EventSubscriberInterface, FieldRemoverInterface
{
    /**
     * @var DepartmentRepositoryInterface
     */
    private $departmentRepository;

    /**
     * @param DepartmentRepositoryInterface $departmentRepository
     */
    public function __construct(DepartmentRepositoryInterface $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }

    /**
     * @param FormEvent $event
     */
    public function remove(FormEvent $event): void
    {
        $form = $event->getForm();
        $data = $event->getData();

        if (array_key_exists('department', $data) && $this->departmentRepository->find($data['department'])) {
            $form->remove('department_text');
        }

        if (array_key_exists('newDepartment', $data) && $this->departmentRepository->find($data['newDepartment'])) {
            $form->remove('new_department_text');
        }
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [FormEvents::PRE_SUBMIT => 'remove'];
    }
}
