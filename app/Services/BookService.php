<?php

namespace App\Services;


use App\Models\Book;
use App\Repositories\BookRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BookService extends BaseService
{
    protected $repository;

    public function __construct(
        BookRepository $repository,
        AuthorService  $authorService,
        SubjectService $subjectService
    )
    {
        $this->repository = $repository;
        $this->authorService = $authorService;
        $this->subjectService = $subjectService;
    }

    /**
     * @param Request $request
     * @return Model
     * @throws \Exception
     */
    public function save(Request $request): Model
    {
        if ($request->input('anoPublicacao') > Carbon::now()->year) {
            throw new \Exception('Não é permitido livros do futuro');
        }

        $book = parent::save($request);

        $paramsAuthors = $this->mountAuthor($request->all(), $book);
        $paramsSubjects = $this->mountSubject($request->all(), $book);

        $book->authors()->createMany($paramsAuthors);
        $book->subjects()->createMany($paramsSubjects);


        return $book;
    }

    /**
     * @param Request $request
     * @param int|string $id
     * @return Model
     * @throws \Exception
     */
    public function update(Request $request, int|string $id): Model
    {
        $book = parent::update($request, $id);

        $paramsAuthors = $this->mountAuthor($request->all(), $book);
        $paramsSubjects = $this->mountSubject($request->all(), $book);

        $book->authors()->delete();
        $book->subjects()->delete();

        $book->authors()->createMany($paramsAuthors);
        $book->subjects()->createMany($paramsSubjects);

        return $book;
    }

    /**
     * @param array $params
     * @param Book $book
     * @return array
     * @throws \Exception
     */
    public function mountAuthor(array $params, Book $book)
    {
        $authorsIds = $params['author_id'] ?? [];
        $paramsAuthors = [];
        foreach ($authorsIds as $idAuthor) {
            if (!$this->authorService->find(($idAuthor))) {
                throw new \Exception('Autor não existe');
            }
            $paramsAuthors[] = [
                'book_id' => $book->id,
                'author_id' => $idAuthor,
            ];
        }
        return $paramsAuthors;
    }

    /**
     * @param array $params
     * @param Book $book
     * @return array
     * @throws \Exception
     */
    public function mountSubject(array $params, Book $book)
    {
        $subjectsId = $params['subject_id'] ?? [];
        $paramsSubjects = [];
        foreach ($subjectsId as $idSubject) {
            if (!$this->subjectService->find(($idSubject))) {
                throw new \Exception('Assunto não existe');
            }
            $paramsSubjects[] = [
                'book_id' => $book->id,
                'subject_id' => $idSubject,
            ];
        }
        return $paramsSubjects;
    }

    /**
     * @param $params
     * @param array $with
     * @return mixed
     */
    public function getAll($params, $with = [])
    {
        return parent::getAll($params, ['authors', 'subjects']);
    }

    /**
     * @param int|string $id
     * @return Model|null
     */
    public function find(int|string $id): ?Model
    {
        return $this->repository->find($id, ['authors', 'subjects']);
    }

    /**
     * @param int|string $id
     */
    public function delete(int|string $id): void
    {
        $item = $this->find($id);
        $item->authors()->delete();
        $item->subjects()->delete();
        parent::delete($id);
    }

    /**
     * @return mixed
     */
    public function preRequisite($id = null)
    {
        $authorService = app()->make(AuthorService::class);
        $subjectService = app()->make(SubjectService::class);

        $arr['authors'] = generateSelectOption($authorService->getRepository()->list());
        $arr['subjects'] = generateSelectOption($subjectService->getRepository()->list());
        return $arr;
    }
}
