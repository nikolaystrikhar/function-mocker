<?php

	namespace tad\FunctionMocker\Call\Verifier;

	use tad\FunctionMocker\Call\Logger\Logger;
	use tad\FunctionMocker\Checker;
	use tad\FunctionMocker\MatchingStrategy\MatchingStrategyFactory;
	use tad\FunctionMocker\ReturnValue;

	class FunctionCallVerifier extends AbstractVerifier {

		/**
		 * @var Checker
		 */
		protected $__checker;

		/** @var  ReturnValue */
		protected $__returnValue;

		/**
		 * @var SpyCallLogger
		 */
		protected $__callLogger;

		public static function __from( Checker $checker, ReturnValue $returnValue, Logger $callLogger ) {
			$instance                = new static;
			$instance->__checker     = $checker;
			$instance->__returnValue = $returnValue;
			$instance->__callLogger  = $callLogger;

			return $instance;
		}

		public function __willReturnCallable() {
			return $this->__returnValue->isCallable();
		}

		public function __wasEvalCreated() {
			return $this->__checker->isEvalCreated();
		}

		public function __getFunctionName() {
			return $this->__checker->getFunctionName();
		}

		/**
		 * Checks if the function or method was called the specified number
		 * of times.
		 *
		 * @param  int $times
		 *
		 * @return void
		 */
		public function wasCalledTimes( $times ) {

			$callTimes        = $this->__callLogger->getCallTimes();
			$functionName = $this->__getFunctionName();

			return $this->matchCallTimes( $times, $callTimes, $functionName );
		}

		/**
		 * Checks if the function or method was called with the specified
		 * arguments a number of times.
		 *
		 * @param  array $args
		 * @param  int   $times
		 *
		 * @return void
		 */
		public function wasCalledWithTimes( array $args = array(), $times ) {

			$callTimes = $this->__callLogger->getCallTimes( $args );
			$functionName = $this->__getFunctionName();

			return $this->matchCallWithTimes( $args, $times, $functionName, $callTimes );
		}
	}
