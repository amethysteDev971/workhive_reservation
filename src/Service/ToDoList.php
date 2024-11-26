<?php

    namespace App\Service;

    use App\Entity\Task;
    use Doctrine\ORM\EntityManagerInterface;

    class ToDoList
    {
        public function __construct(
            private readonly EntityManagerInterface $entityManager
        ) {
        }

        public function getTasks(): array
        {
            return $this->entityManager->getRepository(Task::class)->findAll();
        }

        public function addTask(string $label): void
        {
            $task = new Task();
            $task->setLabel($label);
            $task->setComplete(false);

            $this->entityManager->persist($task);
            $this->entityManager->flush();
        }

        public function deleteTask(int $id): void
        {
            $task = $this->entityManager->getRepository(Task::class)->find($id);
            $this->entityManager->remove($task);
            $this->entityManager->flush();
        }

        public function checkTask(int $id): void
        {
            $task = $this->entityManager->getRepository(Task::class)->find($id);
            $task->setComplete(true);
            $this->entityManager->flush();
        }

        public function uncheckTask(int $id): void
        {
            $task = $this->entityManager->getRepository(Task::class)->find($id);
            $task->setComplete(false);
            $this->entityManager->flush();
        }

        public function toggleTask(int $id): void
        {
            $task = $this->entityManager->getRepository(Task::class)->find($id);
            $task->setComplete(!$task->isComplete());
            $this->entityManager->flush();
        }
    }
