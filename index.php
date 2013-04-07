<?php

    // core includes
    require __DIR__ . '/../rvk/rvk.php';

    // config
    $cfg = array();
    require __DIR__ . '/config.php';
    $config = new Config($cfg);

    // errors log settings
    ExceptionHandler::getInstance()->setLogToFile($config->getValueOr('logErrorsToFile', false));
    ExceptionHandler::getInstance()->setLogFilesPath($config->getValue('logErrorsDirectory'));

    //Env::setMode(Env::PRODUCTION);

    AutoLoad::getInstance()->addPath($config->getValue('controllersDirectory'));
    AutoLoad::getInstance()->addPath($config->getValue('modelsDirectory'));
    AutoLoad::getInstance()->addPath($config->getValue('eventsDirectory'));

    EventManager::getInstance()->on(EventManager::EVENT_BEFORE_ERROR_DISPLAY, new FatalErrorEventHandler());

    // core instance
    $core = new Core();
    $core->getConfig()->merge($config);

    $core->getRouteRules()->addItems(
        array(
            array(  // index
                'url'   => '^$',
                'rUrl'  => 'IndexController/index'
            ),
            array(  // 'item' will replace to 'ItemsCt/description'
                'url'   => '^(item)(\/.+)$',
                'rUrl'  => 'ItemsCt/description$2'
            ),
            array(  // 'text' will replace to 'TextCt'
                'url'   => '^(text)(\/.+)?$',
                'rUrl'  => 'TextCt$2'
            ),
            array(  // wild card
                'url'   => '^(.*)$',
                'rUrl'  => 'IndexController/page404/$0'
            )
        )
    );

    $core->process();

    if (Env::isDevelopment()) {
        $core->getConsole()->dump();
    }

