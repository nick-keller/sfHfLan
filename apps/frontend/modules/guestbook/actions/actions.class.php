<?php

/**
 * guestbook actions.
 *
 * @package    sfHfLan
 * @subpackage guestbook
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class guestbookActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->pager = new sfDoctrinePager(
      'Message',
      sfConfig::get('app_max_msg_on_page')
    );

    $this->pager->setQuery(MessageTable::getInstance()->getOrderedQuery());
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();

    $this->form = new MessageForm();

    if ($request->isMethod('post'))
    {
      $captcha = array(
        'recaptcha_challenge_field' => $request->getParameter('recaptcha_challenge_field'),
        'recaptcha_response_field'  => $request->getParameter('recaptcha_response_field'),
      );
      $this->form->bind(array_merge($request->getParameter($this->form->getName()), array('captcha' => $captcha)));
      if ($this->form->isValid())
      {
        $this->form->save();
      }
      else
      {
        $this->getUser()->setFlash('error', "Erreurs dans le formulaire.", false);
      }
    }
  }
}
