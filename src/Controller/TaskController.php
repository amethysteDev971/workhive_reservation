<?php

    namespace App\Controller;

    use App\Entity\Task;
    use Doctrine\ORM\EntityManagerInterface;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Attribute\Route;

    class TaskController extends AbstractController
    {

        #[Route('/1/', name: 'app_tasks')]
        public function index(EntityManagerInterface $em): Response
        {
            $tasks = $em->getRepository(Task::class)->findAll();

            return $this->render('tasks.html.twig', [
                'tasks' => $tasks
            ]);
        }

        #[Route('/add', name: 'app_task_add')]
        public function create(EntityManagerInterface $em, Request $request): Response
        {
            $label = $request->request->get('task_name');
            $task = new Task();
            $task->setLabel($label);
            $task->setComplete(false);

            $em->persist($task);
            $em->flush();

            return $this->redirectToRoute('app_tasks');
        }

        #[Route('/delete/{id}', name: 'app_task_delete')]
        public function delete(EntityManagerInterface $em, $id): Response
        {
            $task = $em->getRepository(Task::class)->find($id);
            $em->remove($task);
            $em->flush();

            return $this->redirectToRoute('app_tasks');
        }


        #[Route('/toggle/{id}', name: 'app_task_toggle')]
        public function toggle(EntityManagerInterface $em, $id): Response
        {
            $task = $em->getRepository(Task::class)->find($id);
            $task->setComplete(!$task->isComplete());
            $em->flush();

            return $this->redirectToRoute('app_tasks');
        }
    }
