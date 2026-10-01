<?php
class ProjectsController extends Controller
{
    public function index(): string
    {
        $projModel = new Project();
        $taskModel = new Task();

        $projects = $projModel->all();
        $tasks    = $taskModel->all();

        $projectMap = [];
        $totalBudget = 0.0;
        $activeProjects = 0;

        foreach ($projects as $p) {
            $projectMap[$p['id']] = $p['title'];
            $totalBudget += (float)($p['budget'] ?? 0);
            if (($p['status'] ?? '') === 'In Progress') {
                $activeProjects++;
            }
        }

        $openTasks = 0;
        $completedTasks = 0;
        foreach ($tasks as $t) {
            if (($t['status'] ?? '') === 'Completed') {
                $completedTasks++;
            } else {
                $openTasks++;
            }
        }

        return $this->view('projects.index', [
            'projects'       => $projects,
            'tasks'          => $tasks,
            'projectMap'     => $projectMap,
            'totalBudget'    => $totalBudget,
            'activeProjects' => $activeProjects,
            'openTasks'      => $openTasks,
            'completedTasks' => $completedTasks,
        ]);
    }

    public function storeProject(): void
    {
        $projModel = new Project();
        $projModel->create([
            'title'       => $this->request->post('title'),
            'client_name' => $this->request->post('client_name') ?: '',
            'status'      => $this->request->post('status') ?: 'In Progress',
            'priority'    => $this->request->post('priority') ?: 'Medium',
            'start_date'  => $this->request->post('start_date') ?: date('Y-m-d'),
            'end_date'    => $this->request->post('end_date') ?: null,
            'budget'      => (float)($this->request->post('budget') ?: 0),
            'notes'       => $this->request->post('notes') ?: '',
        ]);

        $this->session->flash('success', 'Project created successfully.');
        $this->redirect('/projects');
    }

    public function storeTask(): void
    {
        $taskModel = new Task();
        $taskModel->create([
            'project_id'  => $this->request->post('project_id') ?: null,
            'title'       => $this->request->post('title'),
            'assigned_to' => $this->request->post('assigned_to') ?: 'Team Member',
            'status'      => $this->request->post('status') ?: 'Open',
            'priority'    => $this->request->post('priority') ?: 'Medium',
            'due_date'    => $this->request->post('due_date') ?: date('Y-m-d', strtotime('+7 days')),
        ]);

        $this->session->flash('success', 'Task logged successfully.');
        $this->redirect('/projects');
    }
}
