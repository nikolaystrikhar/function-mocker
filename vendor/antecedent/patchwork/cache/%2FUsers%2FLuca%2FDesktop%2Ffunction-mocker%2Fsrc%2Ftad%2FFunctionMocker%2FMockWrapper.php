<?php

	namespace tad\FunctionMocker; \Patchwork\Interceptor\deployQueue();

	use tad\FunctionMocker\Template\ClassTemplate;
	use tad\FunctionMocker\Template\Extender\ExtenderInterface;
	use tad\FunctionMocker\Template\Extender\SpyExtender;
	use tad\FunctionMocker\Template\MethodCode;

	class MockWrapper {

		/**
		 * @var \PHPUnit_Framework_MockObject_MockObject
		 */
		protected $wrappedObject;

		/**
		 * @var string
		 */
		protected $originalClassName;

		public function getWrappedObject() {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwCalledClass=$__pwClass?\get_called_class():null;$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
			return $this->wrappedObject;
		}

		public function wrap( \PHPUnit_Framework_MockObject_MockObject $mockObject, \PHPUnit_Framework_MockObject_Matcher_InvokedRecorder $invokedRecorder, ReplacementRequest $request ) {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwCalledClass=$__pwClass?\get_called_class():null;$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);

			$extender = new SpyExtender();

			return $this->getWrappedInstance( $mockObject, $extender, $invokedRecorder, $request );
		}

		public function setOriginalClassName( $className ) {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwCalledClass=$__pwClass?\get_called_class():null;$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
			\Arg::_( $className, "Original class name" )->is_string()
			    ->assert( class_exists( $className ) || interface_exists( $className ) || trait_exists( $className ), 'Original class, interface or trait must be defined' );

			$this->originalClassName = $className;
		}


		/**
		 * @param \PHPUnit_Framework_MockObject_MockObject              $object
		 * @param                                                       $extender
		 *
		 * @param \PHPUnit_Framework_MockObject_Matcher_InvokedRecorder $invokedRecorder
		 * @param ReplacementRequest                                    $request
		 *
		 * @throws \Exception
		 *
		 * @return mixed
		 */
		protected function getWrappedInstance( \PHPUnit_Framework_MockObject_MockObject $object, ExtenderInterface $extender, \PHPUnit_Framework_MockObject_Matcher_InvokedRecorder $invokedRecorder = null, ReplacementRequest $request = null ) {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwCalledClass=$__pwClass?\get_called_class():null;$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
			$mockClassName = get_class( $object );
			$extendClassName = sprintf( '%s_%s', uniqid( 'Extended_' ), $mockClassName );
			/** @noinspection PhpUndefinedMethodInspection */
			$extenderClassName = $extender->getExtenderClassName();

			if ( ! class_exists( $extendClassName ) ) {
				$classTemplate = new ClassTemplate();
				$template = $classTemplate->getExtendedMockTemplate();
				$methodCodeTemplate = $classTemplate->getExtendedMethodTemplate();

				/** @noinspection PhpUndefinedMethodInspection */
				$interfaceName = $extender->getExtenderInterfaceName();
				/** @noinspection PhpUndefinedMethodInspection */
				$extendedMethods = $extender->getExtendedMethodCallsAndNames();

				$extendedMethodsCode = array();
				array_walk( $extendedMethods, function ( $methodName, $call ) use ( &$extendedMethodsCode, $methodCodeTemplate ) {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwCalledClass=$__pwClass?\get_called_class():null;$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
					$code = preg_replace( '/%%methodName%%/', $methodName, $methodCodeTemplate );
					$code = preg_replace( '/%%call%%/', $call, $code );
					$extendedMethodsCode[] = $code;
				} );
				$extendedMethodsCode = implode( "\n", $extendedMethodsCode );

				$methodCode = new MethodCode();
				$methodCode->setTargetClass( $this->originalClassName );
				$originalMethodsCode = $methodCode->getAllMockCallings();

				$classCode = preg_replace( '/%%extendedClassName%%/', $extendClassName, $template );
				$classCode = preg_replace( '/%%mockClassName%%/', $mockClassName, $classCode );
				$classCode = preg_replace( '/%%interfaceName%%/', $interfaceName, $classCode );
				$classCode = preg_replace( '/%%extenderClassName%%/', $extenderClassName, $classCode );
				$classCode = preg_replace( '/%%extendedMethods%%/', $extendedMethodsCode, $classCode );
				$classCode = preg_replace( '/%%originalMethods%%/', $originalMethodsCode, $classCode );

				$ok = eval(\Patchwork\Preprocessor\preprocessForEval( $classCode ));

				if ( $ok === false ) {
					throw new \Exception( 'There was a problem evaluating the code' );
				}
			}

			$reflectionClass = new \ReflectionClass($extendClassName);
			$wrapperInstance = $reflectionClass->newInstanceWithoutConstructor();

			/** @noinspection PhpUndefinedMethodInspection */
			$wrapperInstance->__set_functionMocker_originalMockObject( $object );
			$callHandler = new $extenderClassName;
			if ( $invokedRecorder ) {
				/** @noinspection PhpUndefinedMethodInspection */
				$callHandler->setInvokedRecorder( $invokedRecorder );
				/** @noinspection PhpUndefinedMethodInspection */
				$wrapperInstance->__set_functionMocker_invokedRecorder( $invokedRecorder );
			}
			if ( $request ) {
				/** @noinspection PhpUndefinedMethodInspection */
				$callHandler->setRequest( $request );
			}
			/** @noinspection PhpUndefinedMethodInspection */
			$wrapperInstance->__set_functionMocker_callHandler( $callHandler );

			return $wrapperInstance;
		}
	}\Patchwork\Interceptor\deployQueue();