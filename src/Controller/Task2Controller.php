<?php

    namespace App\Controller;

    use App\Service\ToDoList;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Attribute\Route;

    class Task2Controller extends AbstractController
    {

        #[Route('/2/', name: 'app_tasks_2')]
        public function index(ToDoList $todo): Response
        {
            return $this->render('tasks2.html.twig', ['tasks' => $todo->getTasks()]);
        }

        #[Route('/2/add', name: 'app_task_add_2')]
        public function create(ToDoList $todo, Request $request): Response
        {
            $todo->addTask($request->request->get('task_name'));

            return $this->redirectToRoute('app_tasks_2');
        }

        #[Route('/2/delete/{id}', name: 'app_task_delete_2')]
        public function delete(ToDoList $todo, $id): Response
        {
            $todo->deleteTask($id);

            return $this->redirectToRoute('app_tasks_2');
        }


        #[Route('/2/toggle/{id}', name: 'app_task_toggle_2')]
        public function toggle(ToDoList $todo, $id): Response
        {
            $todo->toggleTask($id);

            return $this->redirectToRoute('app_tasks_2');
        }
    }
