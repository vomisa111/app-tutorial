<?php

namespace OCA\NotesTutorial\Controller;

use OCP\IRequest;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Controller;

use OCA\NotesTutorial\Service\NoteService;

class NoteController extends Controller {
    /** @var NoteService */
    private $service;

    private $folder;

    /** @var string */
    private $userId;

    use Errors;

    public function __construct($appName,
                                IRequest $request,
                                NoteService $service,
                                $folder,
                                $userId) {
        parent::__construct($appName, $request);
        $this->service = $service;
        $this->folder = $folder;
        $this->userId = $userId;
    }

    /**
     * @NoAdminRequired
     */
    public function index(): DataResponse {
        return new DataResponse($this->service->findAll($this->userId));
    }

    /**
     * @NoAdminRequired
     */
    public function show(int $id): DataResponse {
        return $this->handleNotFound(function () use ($id) {
            return $this->service->find($id, $this->userId);
        });
    }

    /**
     * @NoAdminRequired
     */
    public function create(string $title, string $content): DataResponse {
        $this->folder->touch('hello_world.txt');

        return new DataResponse($this->service->create($title, $content,
            $this->userId));
    }

    /**
     * @NoAdminRequired
     */
    public function update(int $id, string $title,
                           string $content): DataResponse {
        return $this->handleNotFound(function () use ($id, $title, $content) {
            return $this->service->update($id, $title, $content, $this->userId);
        });
    }

    /**
     * @NoAdminRequired
     */
    public function destroy(int $id): DataResponse {
        return $this->handleNotFound(function () use ($id) {
            return $this->service->delete($id, $this->userId);
        });
    }

}
