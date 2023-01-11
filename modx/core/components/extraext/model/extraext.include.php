<?php

	/**
	 * @class extraExtManagerController
	 * @const GoogleChars
	 */
	if (class_exists('modExtraManagerController')) {
		abstract class extraExtManagerController extends modExtraManagerController
		{
			public const GoogleChars = 'GoogleChars';
			public $componentName = '';
			public $componentUrl = '';
			public $connectorUrl = '';
			public $noManagerMode = FALSE;
			private $cachePaths = [];
			private $cachePathsGet = FALSE;
			/**
			 * @var bool|modCacheManager
			 */
			public $cache = FALSE;
			public $assets = '';
			/**
			 * Turn on for DEV MODE
			 * @var bool
			 */
			public $devMode = FALSE;

			public $components = [
				'Widgets',
				'Grid',
			];

			/**
			 * extraExtManagerController constructor.
			 * @param modX  $modx
			 * @param array $config
			 */
			public function __construct(modX $modx, $config = [])
			{
				parent::__construct($modx, $config);
				try {
					$style = $this->modx->getOption('extraext_highlight_style', NULL, 'github');
					$this->devMode = (bool)$this->modx->getOption('extraExtDevMode', NULL, FALSE);
					$this->cache = $this->modx->getCacheManager();
					$this->cachePaths = $this->cache->get('includes', [xPDO::OPT_CACHE_KEY => 'extraExt']);
					$this->cachePathsGet = TRUE;
					$this->assets = rtrim($modx->getOption('assets_url', NULL, '/assets'), '/') . '/';
					$this->copyright = (bool)$modx->getOption('extraext_copyright', NULL, TRUE);
					$this->componentName = $_GET['namespace'];
					$this->componentUrl = $this->assets . "components/{$this->componentName}/";
					$this->connectorUrl = $this->assets . "components/{$this->componentName}/connector.php";
					$this->languageTopics = [
						'extraext:default',
					];
					$this->extraExtUrl = $this->assets . "components/extraext/";
					$this->extraExtPath = MODX_ASSETS_PATH . "components/extraext/";
					$this->addCss("js/libs/highlight/styles/{$style}.min.css", $this->extraExtUrl);
					$this->addCss('css/main.tab.css', $this->extraExtUrl);
					$this->addCss('css/fontawesome.min.css', $this->extraExtUrl);
					$this->addCss('css/colorpicker.min.css', $this->extraExtUrl);
					$this->addCss('css/firacode.min.css', $this->extraExtUrl);
					$this->addJavascript('js/libs/highlight/highlight.pack.js', $this->extraExtUrl);
					$this->addJavascript('js/libs/showdown/dist/showdown.min.js', $this->extraExtUrl);
					$this->addJavascript('js/libs/moment/moment-with-locales.min.js', $this->extraExtUrl);
					if (!$this->noManagerMode) {
						$this->addJavascript('ajax/libs/js-beautify/1.13.0/beautify.min.js', 'https://cdnjs.cloudflare.com/', TRUE);
						$this->addJavascript('ajax/libs/js-beautify/1.13.0/beautify-css.min.js', 'https://cdnjs.cloudflare.com/', TRUE);
						$this->addJavascript('ajax/libs/js-beautify/1.13.0/beautify-html.min.js', 'https://cdnjs.cloudflare.com/', TRUE);
						$devMode = (int)$this->devMode;
						$this->addHtml("<script type='text/javascript' class='extraExt-constants'>
					const assetsUrl = `{$this->assets}`
					const manager_language = `{$this->modx->getOption('manager_language')}`
					const {$this->componentName}ConnectorUrl = `{$this->connectorUrl}`
					const {$this->componentName}AssetsUrl = `{$this->componentUrl}`
					const extraExtUrl = `{$this->extraExtUrl}`
					const componentName = `{$this->componentName}` 
					const devMode = `{$devMode}`== '0'?false:true
					const ExtraHead = JSON.parse(`" . json_encode($this->ExtraHead) . "`)
					moment.locale(manager_language)
				</script>");
						$this->addJavascript('js/main.js', $this->extraExtUrl);
						$this->addJavascript('js/util.js', $this->extraExtUrl);
						$this->addJavascript('js/inputs/combo.js', $this->extraExtUrl);
						$this->addJavascript('js/inputs/file.js', $this->extraExtUrl);
						$this->addJavascript('js/inputs/colorpicker/colorpicker.js', $this->extraExtUrl);
						$this->addJavascript('js/inputs/colorpicker/colorpickerfield.js', $this->extraExtUrl);
						foreach ($this->components as $component) {
							$this->addComponent($component);
						}
						if ($this->copyright) {
							$this->addHtml($this->_download(MODX_ASSETS_PATH . 'components/extraext/copyleft.tpl'));
						}
					}

				} catch (Exception $e) {
					$this->modx->log(modX::LOG_LEVEL_ERROR, $e->getMessage(), '', __METHOD__ ?: __FUNCTION__, __FILE__, __LINE__);
				}
			}

			public function setFavicon($favicon)
			{
				$h = <<<HTML
<script>
try {
	function changeFavicon(favicon){
		var link = document.querySelector("link[rel~='icon']");
		if (!link) {
		    link = document.createElement('link');
		    link.rel = 'shortcut icon';
		    document.getElementsByTagName('head')[0].appendChild(link);
		}
		link.href = favicon; 
	}
	changeFavicon('{$favicon}')
}catch(e) {
	console.warn('can`t change favicon', e)
}
</script>
HTML;
				$this->addHtml($h);

			}

			/**
			 * @param $name 'GoogleChars'
			 */
			public function addComponent($name)
			{
				$fn = '_add' . ucfirst($name);
				if (method_exists($this, $fn)) {
					$this->$fn();
				}
			}

			public function _addGoogleChars()
			{
				$p = 'js/widgets/google/charts/';
				$this->addJavascript('charts/loader.js', 'https://www.gstatic.com/');
				$this->addJavascript($p . 'line.js', $this->extraExtUrl);
				$this->addJavascript($p . 'area.js', $this->extraExtUrl);
				$this->addJavascript($p . 'pie.js', $this->extraExtUrl);
				$this->addJavascript($p . 'gauge.js', $this->extraExtUrl);
				$this->addJavascript($p . 'annotation.js', $this->extraExtUrl);
				$this->addJavascript($p . 'trendlines.js', $this->extraExtUrl);
				$this->addJavascript($p . 'column.js', $this->extraExtUrl);

			}

			public function _addGrid()
			{
				$p = 'js/widgets/grid/';
				$this->addJavascript($p . 'grid.js', $this->extraExtUrl);
				$this->addJavascript($p . 'editor.js', $this->extraExtUrl);
				$this->addJavascript($p . 'renderer.js', $this->extraExtUrl);
			}

			public function _addWidgets()
			{
				$p = 'js/widgets/';
				$this->addJavascript($p . 'tab.js', $this->extraExtUrl);
				$this->addJavascript($p . 'window.js', $this->extraExtUrl);
				$this->addJavascript($p . 'form.js', $this->extraExtUrl);
				$this->addJavascript($p . 'browser.js', $this->extraExtUrl);

			}

			public function prepareLanguage()
			{
				$this->modx->lexicon->load('action');
				$languageTopics = array_merge($this->languageTopics, $this->getLanguageTopics());
				foreach ($languageTopics as $topic) {
					$this->modx->lexicon->load($topic);
				}
				$this->setPlaceholder('_lang_topics', implode(',', $languageTopics));
				$this->setPlaceholder('_lang', $this->modx->lexicon->fetch());
			}

			/**
			 * @param       $script
			 * @param null  $path
			 * @param       $key
			 * @param false $cache
			 */
			public function addHead($script, $path = NULL, $key, $cache = FALSE)
			{
				$_args = func_get_args();
				if (count($_args) == 1 and is_array($_args[0])) {
					extract($_args[0], EXTR_OVERWRITE);
				}
				$finalPath = '';
				if (!is_null($path)) {
					$finalPath = rtrim($path, '/') . '/' . ltrim($script, '/');
					if ($path === FALSE) {
						$this->modx->log(modX::LOG_LEVEL_ERROR, "can`t load script \"{$finalPath}\"", '', __METHOD__, __FILE__, __LINE__);
					}
				} else {
					$finalPath = $script;
				}
				$t = strpos($finalPath, '//');
				$remote = ($t !== FALSE and $t <= 10) ? TRUE : FALSE;
				if ($cache and $remote) {

					try {
						$hash = md5($finalPath);
						if (empty($this->cachePaths) and $this->cachePathsGet == FALSE) {
							$this->cachePaths = $this->cache->get('includes', [xPDO::OPT_CACHE_KEY => 'extraExt']);
						}
						if (is_array($this->cachePaths) and array_key_exists($hash, $this->cachePaths)) {
							if (file_exists($this->cachePaths[$hash])) {
								throw new Exception($this->cachePaths[$hash], 1);
							}
						}
						if (!is_array($this->cachePaths)) {
							$this->cachePaths = [];
						}
						$ext = $this->baseExt($finalPath);
						$tmp = "cache/" . $hash . '.' . $ext;
						if ($this->_download($finalPath, MODX_ASSETS_PATH . $tmp)) {
							$this->cachePaths[$hash] = rtrim($this->assets, '/') . '/' . ltrim($tmp, '/');
							$this->cache->set('includes', $this->cachePaths, 0, [xPDO::OPT_CACHE_KEY => 'extraExt']);
							throw new Exception($this->cachePaths[$hash], 1);
						} else {
							throw new Exception('', 3);
						}
					} catch (Exception $e) {
						if ($e->getCode() == 0) {
							$finalPath = $script;
						} elseif ($e->getCode() == 1) {
							$finalPath = $e->getMessage();
						} elseif ($e->getCode() == 3) {
						}
					}
				}
				if ($this->devMode and !$remote and in_array($key, ['js', 'lastjs', 'css'])) {
					$absolutPath = ltrim($finalPath, $this->assets);
					if (file_exists(MODX_ASSETS_PATH . $absolutPath)) {
						$v = @md5_file(MODX_ASSETS_PATH . $absolutPath);
					}
					$v = $v ?: time();
					$finalPath .= "?v=" . $v;
				}
				$this->head[$key][] = $finalPath;
				$this->ExtraHead[$key][] = $finalPath;
				array_unique($this->head[$key]);
				return $finalPath;
			}

			/**
			 * @param string $script
			 * @param null   $path
			 * @param false  $cache
			 */
			public function addJavascript($script, $path = NULL, $cache = FALSE)
			{
				$_args = func_get_args();
				if (count($_args) == 1 && is_object($_args[0])) {
					extract($_args[0], EXTR_OVERWRITE);
				}
				return $this->addHead($script, $path, 'js', $cache);
			}

			/**
			 * @param string $script
			 * @param null   $path
			 * @param false  $cache
			 */
			public function addLastJavascript($script, $path = NULL, $cache = FALSE)
			{
				$_args = func_get_args();
				if (count($_args) == 1 and is_object($_args[0])) {
					extract($_args[0], EXTR_OVERWRITE);
				}
				return $this->addHead($script, $path, 'lastjs', $cache);
			}

			/**
			 * @param string $script
			 * @param null   $path
			 * @param false  $cache
			 */
			public function addHtml($script, $path = NULL, $cache = FALSE)
			{
				$_args = func_get_args();
				if (count($_args) == 1 and is_array($_args[0])) {
					extract($_args[0], EXTR_OVERWRITE);
				}
				return $this->addHead($script, $path, 'html', $cache);
			}

			/**
			 * Add a external CSS file to the head of the page
			 * @param string $script
			 * @return void
			 */
			public function addCss($script, $path = NULL, $cache = FALSE)
			{
				$_args = func_get_args();
				if (count($_args) == 1 and is_object($_args[0])) {
					extract($_args[0], EXTR_OVERWRITE);
				}
				return $this->addHead($script, $path, 'css', $cache);

			}

			/**
			 * @param string $file
			 * @param string $outPath
			 * @param bool   $update
			 * @param int    $timeout
			 * @return bool|string
			 */
			private function _download($file = '', $outPath = '', $update = TRUE, $timeout = 2)
			{
				$permissions = (int)($this->modx->config['new_file_permissions'] ?: 0777);
				if (!$update and file_exists($outPath)) {
					return TRUE;
				}

				$opts = [
					'http' => [
						'timeout' => $timeout,
					],
					'https' => [
						'timeout' => $timeout,
					],
				];
				if ($outPath) {
					if (!file_exists(dirname($outPath)) or !is_dir(dirname($outPath))) {
						if (!mkdir($concurrentDirectory = dirname($outPath), $permissions, TRUE) && !is_dir($concurrentDirectory)) {
							throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
						}
					}
				}
				if (version_compare(PHP_VERSION, '7.1.0', '>=')) {
					$ctx = stream_context_create($opts);
					if ($outPath) {
						@file_put_contents($outPath, @file_get_contents($file, 0, $ctx));
					} else {
						return @file_get_contents($file, 0, $ctx);
					}
				} else {
					stream_context_set_default($opts);
					if ($outPath) {
						@file_put_contents($outPath, @file_get_contents($file, 0));
					} else {
						return @file_get_contents($file, 0);
					}
				}

				return file_exists($outPath) and filesize($outPath) > 0;
			}

			/**
			 * @param string $file
			 * @return mixed|string
			 */
			private function baseExt($file = '')
			{
				$_tmp = explode('.', basename($file));
				return end($_tmp);
			}

			public function render()
			{
				if (!$this->noManagerMode) {
					return parent::render();
				}

				if (!$this->checkPermissions()) {
					return $this->modx->error->failure($this->modx->lexicon('access_denied'));
				}
				$this->loadCustomCssJs();
				foreach ($this->head as $key => $Paths) {
					foreach ($Paths as $finalPath) {
						switch ($key) {
							case 'js':
								echo '<script src="' . $finalPath . '" class="ExtraExt"></script>' . PHP_EOL;
								break;
							case 'css':
								echo '<link rel="stylesheet" href="' . $finalPath . '" class="ExtraExt"></script>' . PHP_EOL;
								break;
							case 'lastjs':
								echo '<script defer src="' . $finalPath . '" class="ExtraExt"></script>' . PHP_EOL;
								break;
							case 'html':
								echo $finalPath . PHP_EOL;
								break;
						}
					}
				}
				exit($this->content);
			}
		}
	}
	if (class_exists('modDashboardWidgetInterface')) {
		abstract class extraExtWidgetsController extends modDashboardWidgetInterface
		{
			public const GoogleChars = 'GoogleChars';
			public $componentName = '';
			public $componentUrl = '';
			public $connectorUrl = '';
			private $cachePaths = [];
			private $cachePathsGet = FALSE;
			/**
			 * @var bool|modCacheManager
			 */
			public $cache = FALSE;
			public $assets = '';
			/**
			 * Turn on for DEV MODE
			 * @var bool
			 */
			public $devMode = FALSE;

			public $components = [
				'Widgets',
				'Grid',
			];


			/**
			 * extraExtWidgetsController constructor.
			 * @param xPDO                 $modx
			 * @param modDashboardWidget   $widget
			 * @param modManagerController $controller
			 */
			public function __construct(xPDO &$modx, modDashboardWidget &$widget, modManagerController &$controller)
			{

				parent::__construct($modx, $widget, $controller);
				try {
					$style = $this->modx->getOption('extraext_highlight_style', NULL, 'github');
					$this->devMode = (bool)$this->modx->getOption('extraExtDevMode', NULL, FALSE);
					$this->cache = $this->modx->getCacheManager();
					$this->cachePaths = $this->cache->get('includes', [xPDO::OPT_CACHE_KEY => 'extraExt']);
					$this->cachePathsGet = TRUE;
					$this->assets = rtrim($modx->getOption('assets_url', NULL, '/assets'), '/') . '/';
					$this->copyright = (bool)$modx->getOption('extraext_copyright', NULL, TRUE);
					$this->componentName = $widget->toArray()['namespace'];
					$this->componentUrl = $this->assets . "components/{$this->componentName}/";
					$this->connectorUrl = $this->assets . "components/{$this->componentName}/connector.php";
					$this->languageTopics = [
						'extraext:default',
					];
					$this->extraExtUrl = $this->assets . "components/extraext/";
					$this->extraExtPath = MODX_ASSETS_PATH . "components/extraext/";
					$this->addCss("js/libs/highlight/styles/{$style}.min.css", $this->extraExtUrl);
					$this->addCss('css/main.tab.css', $this->extraExtUrl);
					$this->addCss('css/fontawesome.min.css', $this->extraExtUrl);
					$this->addCss('css/colorpicker.min.css', $this->extraExtUrl);
					$this->addCss('css/firacode.min.css', $this->extraExtUrl);
					$this->addJavascript('js/libs/highlight/highlight.pack.js', $this->extraExtUrl);
					$this->addJavascript('js/libs/showdown/dist/showdown.min.js', $this->extraExtUrl);
					$this->addJavascript('js/libs/moment/moment-with-locales.min.js', $this->extraExtUrl);
					$this->addJavascript('ajax/libs/js-beautify/1.13.0/beautify.min.js', 'https://cdnjs.cloudflare.com/', TRUE);
					$this->addJavascript('ajax/libs/js-beautify/1.13.0/beautify-css.min.js', 'https://cdnjs.cloudflare.com/', TRUE);
					$this->addJavascript('ajax/libs/js-beautify/1.13.0/beautify-html.min.js', 'https://cdnjs.cloudflare.com/', TRUE);
					$devMode = (int)$this->devMode;
					$this->addHtml("<script type='text/javascript' class='extraExt-constants'>
					const assetsUrl = `{$this->assets}`
					const manager_language = `{$this->modx->getOption('manager_language')}`
					const {$this->componentName}ConnectorUrl = `{$this->connectorUrl}`
					const {$this->componentName}AssetsUrl = `{$this->componentUrl}`
					const extraExtUrl = `{$this->extraExtUrl}`
					const componentName = `{$this->componentName}` 
					const devMode = `{$devMode}`== '0'?false:true
					const ExtraHead = JSON.parse(`" . json_encode($this->ExtraHead) . "`)
					moment.locale(manager_language)
				</script>");
					$this->addJavascript('js/main.js', $this->extraExtUrl);
					$this->addJavascript('js/util.js', $this->extraExtUrl);
					$this->addJavascript('js/inputs/combo.js', $this->extraExtUrl);
					$this->addJavascript('js/inputs/colorpicker/colorpicker.js', $this->extraExtUrl);
					$this->addJavascript('js/inputs/colorpicker/colorpickerfield.js', $this->extraExtUrl);
					foreach ($this->components as $component) {
						$this->addComponent($component);
					}
				} catch (Exception $e) {
					$this->modx->log(modX::LOG_LEVEL_ERROR, $e->getMessage(), '', __METHOD__ ?: __FUNCTION__, __FILE__, __LINE__);
				}
			}

			public function setFavicon($favicon)
			{
				$h = <<<HTML
<script>
try {
	function changeFavicon(favicon){
		var link = document.querySelector("link[rel~='icon']");
		if (!link) {
		    link = document.createElement('link');
		    link.rel = 'shortcut icon';
		    document.getElementsByTagName('head')[0].appendChild(link);
		}
		link.href = favicon; 
	}
	changeFavicon('{$favicon}')
}catch(e) {
	console.warn('can`t change favicon', e)
}
</script>
HTML;
				$this->addHtml($h);

			}

			/**
			 * @param $name 'GoogleChars'
			 */
			public function addComponent($name)
			{
				$fn = '_add' . ucfirst($name);
				if (method_exists($this, $fn)) {
					$this->$fn();
				}
			}

			public function _addGoogleChars()
			{
				$p = 'js/widgets/google/charts/';
				$this->addJavascript('charts/loader.js', 'https://www.gstatic.com/');
				$this->addJavascript($p . 'line.js', $this->extraExtUrl);
				$this->addJavascript($p . 'area.js', $this->extraExtUrl);
				$this->addJavascript($p . 'pie.js', $this->extraExtUrl);
				$this->addJavascript($p . 'gauge.js', $this->extraExtUrl);
				$this->addJavascript($p . 'annotation.js', $this->extraExtUrl);
				$this->addJavascript($p . 'trendlines.js', $this->extraExtUrl);
				$this->addJavascript($p . 'column.js', $this->extraExtUrl);

			}

			public function _addGrid()
			{
				$p = 'js/widgets/grid/';
				$this->addJavascript($p . 'grid.js', $this->extraExtUrl);
				$this->addJavascript($p . 'editor.js', $this->extraExtUrl);
				$this->addJavascript($p . 'renderer.js', $this->extraExtUrl);
			}

			public function _addWidgets()
			{
				$p = 'js/widgets/';
				$this->addJavascript($p . 'tab.js', $this->extraExtUrl);
				$this->addJavascript($p . 'window.js', $this->extraExtUrl);
				$this->addJavascript($p . 'form.js', $this->extraExtUrl);
				$this->addJavascript($p . 'browser.js', $this->extraExtUrl);

			}

			public function prepareLanguage()
			{
				$this->modx->lexicon->load('action');
				$languageTopics = array_merge($this->languageTopics, $this->getLanguageTopics());
				foreach ($languageTopics as $topic) {
					$this->modx->lexicon->load($topic);
				}
				$this->setPlaceholder('_lang_topics', implode(',', $languageTopics));
				$this->setPlaceholder('_lang', $this->modx->lexicon->fetch());
			}

			/**
			 * @param       $script
			 * @param null  $path
			 * @param       $key
			 * @param false $cache
			 */
			public function addHead($script, $path = NULL, $key, $cache = FALSE)
			{
				$_args = func_get_args();
				if (count($_args) == 1 and is_array($_args[0])) {
					extract($_args[0], EXTR_OVERWRITE);
				}
				$finalPath = '';
				if (!is_null($path)) {
					$finalPath = rtrim($path, '/') . '/' . ltrim($script, '/');
					if ($path === FALSE) {
						$this->modx->log(modX::LOG_LEVEL_ERROR, "can`t load script \"{$finalPath}\"", '', __METHOD__, __FILE__, __LINE__);
					}
				} else {
					$finalPath = $script;
				}
				$t = strpos($finalPath, '//');
				$remote = ($t !== FALSE and $t <= 10) ? TRUE : FALSE;
				if ($cache and $remote) {

					try {
						$hash = md5($finalPath);
						if (empty($this->cachePaths) and $this->cachePathsGet == FALSE) {
							$this->cachePaths = $this->cache->get('includes', [xPDO::OPT_CACHE_KEY => 'extraExt']);
						}
						if (is_array($this->cachePaths) and array_key_exists($hash, $this->cachePaths)) {
							if (file_exists($this->cachePaths[$hash])) {
								throw new Exception($this->cachePaths[$hash], 1);
							}
						}
						if (!is_array($this->cachePaths)) {
							$this->cachePaths = [];
						}
						$ext = $this->baseExt($finalPath);
						$tmp = "cache/" . $hash . '.' . $ext;
						if ($this->_download($finalPath, MODX_ASSETS_PATH . $tmp)) {
							$this->cachePaths[$hash] = rtrim($this->assets, '/') . '/' . ltrim($tmp, '/');
							$this->cache->set('includes', $this->cachePaths, 0, [xPDO::OPT_CACHE_KEY => 'extraExt']);
							throw new Exception($this->cachePaths[$hash], 1);
						} else {
							throw new Exception('', 3);
						}
					} catch (Exception $e) {
						if ($e->getCode() == 0) {
							$finalPath = $script;
						} elseif ($e->getCode() == 1) {
							$finalPath = $e->getMessage();
						} elseif ($e->getCode() == 3) {
						}
					}
				}
				if ($this->devMode and !$remote and in_array($key, ['js', 'lastjs', 'css'])) {
					$absolutPath = ltrim($finalPath, $this->assets);
					if (file_exists(MODX_ASSETS_PATH . $absolutPath)) {
						$v = @md5_file(MODX_ASSETS_PATH . $absolutPath);
					}
					$v = $v ?: time();
					$finalPath .= "?v=" . $v;
				}
				$this->head[$key][] = $finalPath;
				$this->ExtraHead[$key][] = $finalPath;
				array_unique($this->head[$key]);
				return $finalPath;
			}

			/**
			 * @param string $script
			 * @param null   $path
			 * @param false  $cache
			 */
			public function addJavascript($script, $path = NULL, $cache = FALSE)
			{
				$_args = func_get_args();
				if (count($_args) == 1 and is_object($_args[0])) {
					extract($_args[0], EXTR_OVERWRITE);
				}
				return $this->addHead($script, $path, 'js', $cache);
			}

			/**
			 * @param string $script
			 * @param null   $path
			 * @param false  $cache
			 */
			public function addLastJavascript($script, $path = NULL, $cache = FALSE)
			{
				$_args = func_get_args();
				if (count($_args) == 1 and is_object($_args[0])) {
					extract($_args[0], EXTR_OVERWRITE);
				}
				return $this->addHead($script, $path, 'lastjs', $cache);
			}

			/**
			 * @param string $script
			 * @param null   $path
			 * @param false  $cache
			 */
			public function addHtml($script, $path = NULL, $cache = FALSE)
			{
				$_args = func_get_args();
				if (count($_args) == 1 and is_array($_args[0])) {
					extract($_args[0], EXTR_OVERWRITE);
				}
				return $this->addHead($script, $path, 'html', $cache);
			}

			/**
			 * Add a external CSS file to the head of the page
			 * @param string $script
			 * @return void
			 */
			public function addCss($script, $path = NULL, $cache = FALSE)
			{
				$_args = func_get_args();
				if (count($_args) == 1 and is_object($_args[0])) {
					extract($_args[0], EXTR_OVERWRITE);
				}
				return $this->addHead($script, $path, 'css', $cache);

			}

			/**
			 * @param string $file
			 * @param string $outPath
			 * @param bool   $update
			 * @param int    $timeout
			 * @return bool|string
			 */
			private function _download($file = '', $outPath = '', $update = TRUE, $timeout = 2)
			{
				$permissions = (int)($this->modx->config['new_file_permissions'] ?: 0777);
				if (!$update and file_exists($outPath)) {
					return TRUE;
				}

				$opts = [
					'http' => [
						'timeout' => $timeout,
					],
					'https' => [
						'timeout' => $timeout,
					],
				];
				if ($outPath) {
					if (!file_exists(dirname($outPath)) or !is_dir(dirname($outPath))) {
						if (!mkdir($concurrentDirectory = dirname($outPath), $permissions, TRUE) && !is_dir($concurrentDirectory)) {
							throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
						}
					}
				}
				if (PHP_VERSION_ID >= 70100) {
					$ctx = stream_context_create($opts);
					if ($outPath) {
						@file_put_contents($outPath, @file_get_contents($file, 0, $ctx));
					} else {
						return @file_get_contents($file, 0, $ctx);
					}
				} else {
					stream_context_set_default($opts);
					if ($outPath) {
						@file_put_contents($outPath, @file_get_contents($file, 0));
					} else {
						return @file_get_contents($file, 0);
					}
				}

				if (file_exists($outPath) and filesize($outPath) > 0) {
					return TRUE;
				} else {
					return FALSE;
				}
			}

			/**
			 * @param string $file
			 * @return mixed|string
			 */
			private function baseExt($file = '')
			{
				$_tmp = explode('.', basename($file));
				return end($_tmp);
			}

			abstract function loadCustomCssJs();

			final public function render()
			{
				$content = '';
				$this->loadCustomCssJs();
				foreach ($this->head as $key => $Paths) {
					foreach ($Paths as $finalPath) {
						switch ($key) {
							case 'js':
								$this->content .= '<script src="' . $finalPath . '" class="ExtraExt"></script>' . PHP_EOL;
								break;
							case 'css':
								$this->content .= '<link rel="stylesheet" href="' . $finalPath . '" class="ExtraExt"></script>' . PHP_EOL;
								break;
							case 'lastjs':
								$this->content .= '<script defer src="' . $finalPath . '" class="ExtraExt"></script>' . PHP_EOL;
								break;
							case 'html':
								$this->content .= $finalPath . PHP_EOL;
								break;
						}
					}
				}
				return $this->content;
			}
		}
	}