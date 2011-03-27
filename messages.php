<?php
/**
 * Componente de mensagens
 *
 * Facilita a exibição dos três tipos de mensagem e o redirecionamento
 *
 * @author Thiago Belem <contato@thiagobelem.net>
 *
 * @package CakePHP
 * @subpackage Components
 * @filesource
 */

/**
 * Componente de mensagens
 *
 * Facilita a exibição dos três tipos de mensagem e o redirecionamento
 *
 * @author Thiago Belem <contato@thiagobelem.net>
 *
 * @package CakePHP
 * @subpackage Components
 */
class MessagesComponent extends Object {

	/**
	 * Nome do componente
	 *
	 * @var string
	 * @ignore
	 */
	public $name = 'Messages';

	/**
	 * Outros componentes utilizados pelo componente
	 *
	 * @var array
	 */
	public $components = array('Session');

	/**
	 * Elemento da mensagem de informação
	 */
	const ELEMENT_INFO = 'messages/info';

	/**
	 * Elemento da mensagem de sucesso
	 */
	const ELEMENT_SUCCESS = 'messages/success';

	/**
	 * Elemento da mensagem de erros
	 */
	const ELEMENT_ERROR = 'messages/error';

	/**
	 * Inicializa o componente salvando o controller
	 *
	 * @ignore
	 */
	function initialize(&$controller) {
		$this->controller =& $controller;
	}

	/**
	 * Manipula o redirecionamento
	 *
	 * Se o parâmetro $redirect for um array(controller, action) tentará redirecionar
	 *  para essa action, caso contrário irá tentar redirecionar para a página anterior,
	 *  caso não consiga, redireciona o visitante para a página inicial do site
	 *
	 * @param mixed $redirect Endereço para redirecionar o visitante
	 *
	 * @uses Controller::redirect()
	 * @uses Controller::referer()
	 *
	 * @return void
	 */
	private function handleRedirect($redirect) {
		if (is_array($redirect))
			$this->controller->redirect($redirect);
		else
			$this->controller->redirect($this->controller->referer(null, true));
	}

	/**
	 * Exibe uma mensagem flash e redireciona o usuário (opcionalmente)
	 *
	 * @param string $text Texto da mensagem
	 * @param string $layout Layout da mensagem
	 * @param array $vars Variáveis extras para a mensagem
	 * @param mixed $redirect Redireciona o visitante?
	 *
	 * @uses SessionComponent::setFlash()
	 *
	 * @return void
	 */
	private function displayMessageAndRedirect($text, $layout, $vars = array(), $redirect = false) {
		$this->Session->setFlash($text, $layout, $vars);

		if ($redirect)
			$this->handleRedirect($redirect);
	}

	/**
	 * Exibe uma mensagem de informação
	 *
	 * Exemplo:
	 * <code>
	 * // Apenas exibe a mensagem de informação
	 * $this->Message->info('Seja bem vindo, Usuário!');
	 *
	 * // Exibe a mensagem e redireciona o visitante
	 * $this->Message->info('Seja bem vindo, Usuário!',
	 * 	array('title' => 'Olá!'),
	 * 	array('controller' => 'news', 'action' => 'index'));
	 * </code>
	 *
	 * @param string $text Texto da mensagem
	 * @param array $vars Variáveis extras para a mensagem
	 * @param mixed $redirect Redireciona o visitante?
	 *
	 * @uses MessagesComponent::displayMessageAndRedirect()
	 *
	 * @return void
	 */
	public function info($text, $vars = array(), $redirect = false) {
		$this->displayMessageAndRedirect($text, self::ELEMENT_INFO, $vars, $redirect);
	}

	/**
	 * Exibe uma mensagem de sucesso
	 *
	 * Exemplo:
	 * <code>
	 * // Apenas exibe a mensagem de sucesso
	 * $this->Message->success('Usuário cadastrado com sucesso!');
	 *
	 * // Exibe a mensagem e redireciona o visitante para a página anterior
	 * $this->Message->success('Usuário cadastrado com sucesso!',
	 * 	array('title' => 'Sucesso!'),
	 * 	true);
	 * </code>
	 *
	 * @param string $text Texto da mensagem
	 * @param array $vars Variáveis extras para a mensagem
	 * @param mixed $redirect Redireciona o visitante?
	 *
	 * @uses MessagesComponent::displayMessageAndRedirect()
	 *
	 * @return void
	 */
	public function success($text, $vars = array(), $redirect = false) {
		$this->displayMessageAndRedirect($text, self::ELEMENT_SUCCESS, $vars, $redirect);
	}

	/**
	 * Exibe uma mensagem de erro
	 *
	 * Exemplo:
	 * <code>
	 * // Apenas exibe a mensagem de informação
	 * $this->Message->error('Usuário não encontrado!');
	 *
	 * // Exibe a mensagem e redireciona o visitante a página anterior
	 * $this->Message->error('Usuário não encontrado!',
	 * 	array('title' => 'Erro!'),
	 * 	true);
	 * </code>
	 *
	 * @param string $text Texto da mensagem
	 * @param array $vars Variáveis extras para a mensagem
	 * @param mixed $redirect Redireciona o visitante?
	 *
	 * @uses MessagesComponent::displayMessageAndRedirect()
	 *
	 * @return void
	 */
	public function error($text, $vars = array(), $redirect = false) {
		$this->displayMessageAndRedirect($text, self::ELEMENT_ERROR, $vars, $redirect);
	}
}