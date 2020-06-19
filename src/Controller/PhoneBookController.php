<?php

namespace App\Controller;

use App\Entity\PhoneBook;
use App\Form\PhoneBookType;
use App\Repository\PhoneBookRepository;
use App\Service\PhoneBookService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 */
class PhoneBookController extends AbstractController
{
    private $pbService;

    public function __construct(PhoneBookService $phoneBookService) {
        $this->pbService = $phoneBookService;
    }

    /**
     * @Route("/", name="phone_book_index", methods={"GET"})
     */
    public function index(PhoneBookRepository $phoneBookRepository): Response
    {
        return $this->render('phone_book/index.html.twig', [
            'phone_books' => $phoneBookRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="phone_book_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $phoneBook = new PhoneBook();
        $form = $this->createForm(PhoneBookType::class, $phoneBook);
        $phone = preg_replace('/\D/', '', $request->request->get('phone_book')['phone']);
        $fullName = $request->request->get('phone_book')['full_name'];
        $params = [
            'phone' => $phone,
            'full_name' => $fullName
        ];
        $request->request->set('phone', $phone);
        $form->handleRequest($request);

        $phoneBookRepository = $this->getDoctrine()->getRepository(PhoneBook::class);
        if ($phoneBookRepository->findAllBy($params)) {
            $form->addError(new FormError("Такая запись уже существует"));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->pbService->new($params);

            return $this->redirectToRoute('phone_book_index');
        }

        return $this->render('phone_book/new.html.twig', [
            'phone_book' => $phoneBook,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="phone_book_show", methods={"GET"}, requirements={"id":"\d+"})
     */
    public function show(PhoneBook $phoneBook): Response
    {
        return $this->render('phone_book/show.html.twig', [
            'phone_book' => $phoneBook,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="phone_book_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PhoneBook $phoneBook): Response
    {
        $form = $this->createForm(PhoneBookType::class, $phoneBook);
        $phone = preg_replace('/\D/', '', $request->request->get('phone_book')['phone']);
        $fullName = $request->request->get('phone_book')['full_name'];
        $params = [
            'phone' => $phone,
            'full_name' => $fullName
        ];

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->pbService->edit($params, $phoneBook);

            return $this->redirectToRoute('phone_book_index');
        }

        return $this->render('phone_book/edit.html.twig', [
            'phone_book' => $phoneBook,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="phone_book_delete", methods={"DELETE"})
     */
    public function delete(Request $request, PhoneBook $phoneBook): Response
    {
        if ($this->isCsrfTokenValid('delete'.$phoneBook->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($phoneBook);
            $entityManager->flush();
        }

        return $this->redirectToRoute('phone_book_index');
    }
    /**
     * @Route("/filter", name="phone_book_filter", methods={"POST"})
     */
    public function filter(Request $request): Response
    {
        $rep = $this->getDoctrine()->getRepository(PhoneBook::class);
        $filterParams = [];
        foreach ($request->request->all() as $key => $value) {
            if (! empty(trim($value))) {
                if ('phone' === $key) {
                    $value = preg_replace('/\D/', '', $value);
                }
                $filterParams[$key] = $value;
            }
        }
//        var_dump($filterParams);
        $res = $rep->findAllBy($filterParams);

        return new Response(json_encode($res));
    }

}
