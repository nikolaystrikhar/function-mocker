<?php

	namespace tad\FunctionMocker\Template\Extender;


	abstract class AbstractExtender implements Extender {

		/**
		 * @var string
		 */
		protected $extenderClassName;

		/**
		 * @var string
		 */
		protected $extenderInterfaceName;

		public function getExtenderClassName() {
			return $this->extenderClassName;
		}

		public function getExtenderInterfaceName() {
			return $this->extenderInterfaceName;
		}
	}
