<?php
class UserController extends Controller
{
    private User $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
    }

    public function index(): string
    {
        $users = $this->userModel->all();
        return $this->view('users.index', [
            'users'   => $users,
            'success' => $this->session->getFlash('success'),
            'error'   => $this->session->getFlash('error'),
        ]);
    }

    public function create(): string
    {
        return $this->view('users.create', [
            'error' => $this->session->getFlash('error'),
        ]);
    }

    public function store(): string
    {
        $name     = $this->request->post('name');
        $email    = $this->request->post('email');
        $password = $this->request->post('password');
        $role     = $this->request->post('role') ?: 'staff';
        $status   = $this->request->post('status') ?: 'active';

        if (empty($name) || empty($email) || empty($password)) {
            $this->session->flash('error', 'Name, email and password are required.');
            return $this->redirect(url('/users/create'));
        }

        if ($this->userModel->findByEmail($email)) {
            $this->session->flash('error', 'A user with this email already exists.');
            return $this->redirect(url('/users/create'));
        }

        $this->userModel->createUser([
            'name'     => $name,
            'email'    => $email,
            'password' => $password,
            'role'     => $role,
            'status'   => $status,
        ]);

        $this->session->flash('success', 'User created successfully.');
        return $this->redirect(url('/users'));
    }

    public function edit(): string
    {
        $id = (int)$this->request->get('id');
        $user = $this->userModel->find($id);

        if (!$user) {
            $this->session->flash('error', 'User not found.');
            return $this->redirect(url('/users'));
        }

        return $this->view('users.edit', [
            'user'  => $user,
            'error' => $this->session->getFlash('error'),
        ]);
    }

    public function update(): string
    {
        $id       = (int)$this->request->post('id');
        $name     = $this->request->post('name');
        $email    = $this->request->post('email');
        $password = $this->request->post('password');
        $role     = $this->request->post('role') ?: 'staff';
        $status   = $this->request->post('status') ?: 'active';

        $data = [
            'name'   => $name,
            'email'  => $email,
            'role'   => $role,
            'status' => $status,
        ];

        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $this->userModel->update($id, $data);
        $this->session->flash('success', 'User updated successfully.');
        return $this->redirect(url('/users'));
    }

    public function delete(): string
    {
        $id = (int)$this->request->post('id');
        $currentUser = $this->session->get('user');

        if ($currentUser['id'] == $id) {
            $this->session->flash('error', 'You cannot delete your own account.');
            return $this->redirect(url('/users'));
        }

        $this->userModel->delete($id);
        $this->session->flash('success', 'User deleted successfully.');
        return $this->redirect(url('/users'));
    }
}
