<?php

class TournamentChooserForm extends BaseForm
{
  public function configure()
  {
    $event = $this->getOption('event');
    $tournaments = array();
    foreach($event->getTournaments() as $tournament)
    {
      $tournaments[$tournament->getId()] = $tournament->getName();
      if($tournament->isFull())
      {
        $tournaments[$tournament->getId()] .= " (complet)";
      }
    }
    
    $this->setWidget('tournament', new sfWidgetFormChoice(array(
              'choices' => $tournaments,
              'expanded' => false
            )));

    $this->setValidator('tournament', new sfValidatorChoice(array(
      'choices' => array_keys($tournaments)
    )));

    $this->widgetSchema->setLabel('tournament', 'Choisissez un tournoi :');
  }
}