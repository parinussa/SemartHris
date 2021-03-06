<?php

namespace KejawenLab\Application\SemartHris\Form\EventListener;

use KejawenLab\Application\SemartHris\Component\Job\Repository\JobTitleRepositoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@kejawenlab.com>
 */
final class RemoveJobTitleTextFieldSubscriber implements EventSubscriberInterface, FieldRemoverInterface
{
    /**
     * @var JobTitleRepositoryInterface
     */
    private $jobTitleRepository;

    /**
     * @param JobTitleRepositoryInterface $jobTitleRepository
     */
    public function __construct(JobTitleRepositoryInterface $jobTitleRepository)
    {
        $this->jobTitleRepository = $jobTitleRepository;
    }

    /**
     * @param FormEvent $event
     */
    public function remove(FormEvent $event): void
    {
        $form = $event->getForm();
        $data = $event->getData();

        if (array_key_exists('jobTitle', $data) && $this->jobTitleRepository->find($data['jobTitle'])) {
            $form->remove('jobtitle_text');
        }

        if (array_key_exists('newJobTitle', $data) && $this->jobTitleRepository->find($data['newJobTitle'])) {
            $form->remove('new_jobtitle_text');
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
