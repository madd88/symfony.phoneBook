<?php


namespace App\Service;


use App\Entity\PhoneBook;
use Doctrine\ORM\EntityManagerInterface;

class PhoneBookService {

    private $em;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->em = $entityManager;
    }

    /**
     * Создание записи
     *
     * @param $params
     * @return bool
     * @throws \Exception
     */
    public function new($params)
    : bool {
        try {
            $phoneBook = new PhoneBook();
            $phoneBook->setPhone($params['phone']);
            $phoneBook->setFullName($params['full_name']);
            $this->em->persist($phoneBook);
            $this->em->flush();
        } catch (\Throwable $e) {
            throw new \Exception($e->getMessage());
        }

        return true;
    }

    /**
     * Редактирование записи
     *
     * @param array $params
     * @param PhoneBook $phoneBook
     * @return bool
     * @throws \Exception
     */
    public function edit(array $params, PhoneBook $phoneBook)
    : bool {
        try {
            $phoneBook->setPhone($params['phone']);
            $phoneBook->setFullName($params['full_name']);
            $this->em->persist($phoneBook);
            $this->em->flush();
        } catch (\Throwable $e) {
            throw new \Exception($e->getMessage());
        }

        return true;
    }

}