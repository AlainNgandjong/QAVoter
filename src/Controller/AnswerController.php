<?php

namespace App\Controller;


use App\Entity\Answer;
use App\Entity\Question;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Sentry\State\HubInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnswerController extends AbstractController
{
    #[Route('/answers/{id}/vote', name: 'answer_vote', methods: "POST")]
    public function answerVote(Answer $answer, LoggerInterface $logger, Request $request, EntityManagerInterface $entityManager)
    {
        $data = json_decode($request->getContent(), true);
        $direction = $data['direction'] ?? 'up';
        // use real logic here to save this to the database
        if ($direction === 'up') {
            $logger->info('Voting up!');
            $answer->setVotes($answer->getVotes() + 1);
        } else {
            $logger->info('Voting down!');
            $answer->setVotes($answer->getVotes() - 1);
        }
        $entityManager->flush();
        return $this->json(['votes' => $answer->getVotes()]);
    }


}
