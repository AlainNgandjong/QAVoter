<?php

namespace App\Controller;


use App\Entity\Question;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sentry\State\HubInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(QuestionRepository $questionRepository): Response
    {
        $questions = $questionRepository->findAllAskedOrderdByNewest();

        return $this->render('question/homepage.html.twig', [
            'questions' => $questions
        ]);
    }

    #[Route('/questions/new', name: 'app_question_new')]
    public function new(EntityManagerInterface $entityManager)
    {
        return new Response('TODO questions/new page');
    }

    #[Route('/questions/{slug}', name: 'app_question_show')]
    public function show(Question $question, EntityManagerInterface $entityManager)
    {

        $answers = [
            'Make sure your cat is sitting purrrfectly still 🤣',
            'Honestly, I like furry shoes better than MY cat',
            'Maybe... try saying the spell backwards?',
        ];
        $questionText = "I've been turned into a cat, any thoughts on how to turn back? While I'm **adorable**, I don't really care for cat food.";

        return $this->render('question/show.html.twig', [
            'question' => $question,
            'answers' => $answers,
            'questionText' => $questionText
        ]);
    }

    #[Route('/questions/{slug}/vote', name: 'app_question_vote', methods: "POST")]
    public function questionVote(Question $question, Request $request, EntityManagerInterface $em)
    {
        $direction  = $request->request->get('direction');
        if ($direction === 'up') {
            $question->upVote();
        } elseif ($direction === 'down') {
            $question->downVote();
        }

        $em->flush();

        return $this->redirectToRoute('app_question_show', [
            'slug' => $question->getSlug()
        ]);

    }


}
