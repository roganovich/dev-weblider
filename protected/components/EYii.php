<?php

class EYii {

    /**
     * Возвращает относительный URL приложения
     * @return string
     */
    public static function baseUrl() {
        return Yii::app()->baseUrl;
    }

    static function getLink($link) {
        $link = "#" . $link;
        if (Yii::app()->request->url != '/') {
            return "/" . $link;
        }
        return $link;
    }

    /**
     * Возвращает ссылку на кэш-компонент приложения
     * @return CCache
     */
    public static function cache() {
        return Yii::app()->cache;
    }

    /**
     * Удаляет кэш с ключом $id
     * @param string $id имя ключа
     * @return boolean
     */
    public static function cacheDelete($id) {
        return Yii::app()->cache->delete($id);
    }

    /**
     * Возвращает значение кэша с ключом $id
     * @param string $id имя ключа
     * @return mixed
     */
    public static function cacheGet($id) {
        return Yii::app()->cache->get($id);
    }

    /**
     * Сохраняет значение $value в кэш с ключом $id на время $expire (сек)
     * @param string $id имя ключа
     * @param mixed $value значение ключа
     * @param integer $expire время хранения в секундах
     * @param ICacheDependency $dependency
     * @return boolean
     */
    public static function cacheSet($id, $value, $expire = 0, $dependency = NULL) {
        return Yii::app()->cache->set($id, $value, $expire, $dependency);
    }

    /**
     * Удаляет куку
     * @param string $name имя куки
     */
    public static function cookieDelete($name) {
        if (isset(Yii::app()->request->cookies[$name])) {
            unset(Yii::app()->request->cookies[$name]);
        }
    }

    /**
     * Возвращает значение куки
     * @param string $name имя куки
     * @return string|null
     */
    public static function cookieGet($name) {
        if (isset(Yii::app()->request->cookies[$name])) {
            return Yii::app()->request->cookies[$name]->value;
        }

        return null;
    }

    /**
     * Устанавливает куку
     * @param string $name имя куки
     * @param string $value значение куки
     * @param integer $expire seconds время хранения (time() + ...) в секундах
     * @param string $path путь на сайте, для которого кука действительна
     * @param string $domain домен, для которого кука действительна
     */
    public static function cookieSet($name, $value, $expire = null, $path = '/', $domain = null) {
        $cookie = new CHttpCookie($name, $value);
        $cookie->expire = $expire ? $expire : 0;
        $cookie->path = $path ? $path : '';
        $cookie->domain = $domain ? $domain : '';
        Yii::app()->request->cookies[$name] = $cookie;
    }

    /**
     * Возвращает значение токена CSRF
     * @return string
     */
    public static function csrf() {
        return Yii::app()->request->csrfToken;
    }

    /**
     * Возвращает имя токена CSRF (по умолчанию YII_CSRF_TOKEN)
     * @return string
     */
    public static function csrfName() {
        return Yii::app()->request->csrfTokenName;
    }

    /**
     * Возвращает готовую строчку для передачи CSRF-параметра в ajax-запросе
     * Пример с использованием jQuery:
     *      $.post('url', { param: 'blabla', <?=Y::csrfJsParam();?> }, ...)
     * будет соответственно заменено на:
     *      $.post('url', { param: 'blabla', [csrfName]: '[csrfToken]' }, ...)
     * @return string
     */
    public static function csrfJsParam() {
        return Yii::app()->request->csrfTokenName . ":'" . Yii::app()->request->csrfToken . "'";
    }

    /**
     * Ярлык функции dump класса CVarDumper для отладки приложения
     * @param mixed $var переменная для вывода
     */
    public static function dump($var, $toDie = true) {
        echo '<pre>';
        CVarDumper::dump($var, 10, true);
        echo '</pre>';

        if ($toDie) {
            Yii::app()->end();
        }
    }

    public static function getDump($arr) {
        ob_start();
        self::dump($arr, false);
        $data = ob_get_clean();

        return $data;
    }

    /**
     * Выводит текст и завершает приложение (применяется в ajax-действиях)
     * @param string $text текст для вывода
     */
    public static function end($text = '') {
        echo $text;
        Yii::app()->end();
    }

    /**
     * Выводит данные в формате JSON и завершает приложение (применяется в ajax-действиях)
     * @param string $data данные для вывода
     */
    public static function endJson($data) {
        echo CJSON::encode($data);
        Yii::app()->end();
    }

    /**
     * Устанавливает флэш-извещение для юзера
     * @param string $key ключ извещения
     * @param string $msg сообщение извещения
     */
    public static function flash($msg, $autoHide = false, $cssClass = "alert-success alert") {
        $msg = ($msg) ? '<div class="' . $cssClass . (($autoHide == true) ? " flash-hide" : "") . '">' . $msg . '</div>' : NULL;
        if ($autoHide == true) {
            Yii::app()->clientScript->registerScript("flash_hide", "jQuery('.flash-hide').animate({opacity: 1.0}, 5000).fadeOut('slow');");
        }
        Yii::app()->user->setFlash(Yii::app()->controller->id, $msg);
    }

    /**
     * Получаем флэш-извещение для юзера
     * @param string $key ключ извещения
     */
    public static function getFlash($key = null) {
        if (!$key)
            $key = Yii::app()->controller->id;
        if (Yii::app()->user->hasFlash($key)) {
            echo Yii::app()->user->getFlash($key);
        } else {
            echo "";
        }
    }

    /**
     * Проверка наличия определенной роли у текущего пользователя
     * @param string $roleName имя роли
     * @return boolean
     * @since 1.0.2
     */
    public static function hasAccess($roleName) {
        return Yii::app()->user->checkAccess($roleName);
    }

    /**
     * Возвращает true, если пользователь авторизован, иначе - false
     * @return boolean
     */
    public static function isAuthed() {
        return !Yii::app()->user->isGuest;
    }

    /**
     * Возвращает true, если пользователь гость и неавторизован, иначе - false
     * @return boolean
     */
    public static function isGuest() {
        return Yii::app()->user->isGuest;
    }

    /**
     * Возвращает пользовательский параметр приложения с именем $key
     * @param string $key ключ параметра или ключи через точку вложенных параметров
     * 'Media.Foto.thumbsize' преобразуется в ['Media']['Foto']['thumbsize']
     * @return mixed
     */
    public static function param($key) {
        if ($key == 'kotir_eurusd') {
            $criteria = new CDbCriteria;
            $criteria->order = 'id DESC';
            $criteria->addCondition('status = 1');
            $k = HKurs::model()->find($criteria);
            if ($k) {
                return $k->kurs_eur_usd;
            }
        }
        if (strpos($key, '.') === false) {
            return Yii::app()->params[$key];
        }

        $keys = explode('.', $key);
        $param = Yii::app()->params[$keys[0]];
        unset($keys[0]);

        foreach ($keys as $k) {
            if (!isset($param[$k])) {
                return null;
            }

            $param = $param[$k];
        }

        return $param;
    }

    /**
     * Редиректит по указанному маршруту
     * @param string $route маршрут
     * @param array $params дополнительные параметры маршрута
     */
    public static function redir($route, $params = array()) {
        if (self::isAjax()) {
            self::end();
        } else {
            Yii::app()->request->redirect(self::url($route, $params));
        }
    }

    /**
     * Редиректит по указанному маршруту
     * @param string $link маршрут
     */
    public static function redirLink($link) {
        if (self::isAjax()) {
            self::end();
        } else {
            Yii::app()->request->redirect(Yii::app()->createUrl($link));
        }
    }

    /**
     * Редиректит по на пред страницу
     */
    public static function redirReferer() {
        if (self::isAjax()) {
            self::end();
        } else {
            Yii::app()->request->redirect($_SERVER['HTTP_REFERER']);
        }
    }

    /**
     * Обновление страницы
     */
    public static function refresh() {
        if (self::isAjax()) {
            self::end();
        } else {
            Yii::app()->controller->refresh();
        }
    }

    /**
     * Редиректит по указанному роуту, если юзер авторизован
     * @param string $route маршрут
     * @param array $params дополнительные параметры маршрута
     */
    public static function redirAuthed($route, $params = array()) {
        if (!Yii::app()->user->isGuest) {
            Yii::app()->request->redirect(self::url($route, $params));
        }
    }

    /**
     * Редиректит по указанному роуту, если юзер гость
     * @param string $route маршрут
     * @param array $params дополнительные параметры маршрута
     */
    public static function redirGuest($route, $params = array()) {
        if (Yii::app()->user->isGuest) {
            Yii::app()->request->redirect(self::url($route, $params));
        }
    }

    /**
     * Возвращает ссылку на компонент request
     * @return CHttpRequest
     */
    public static function request() {
        return Yii::app()->request;
    }

    /**
     * Возвращает true если это ajax запрос
     * @return CHttpRequest
     */
    public static function isAjax() {
        return Yii::app()->request->isAjaxRequest;
    }

    /**
     * Возвращает getQuery()
     * @return CHttpRequest
     */
    public static function getQuery($name) {
        return Yii::app()->request->getQuery($name);
    }

    /**
     * Возвращает getPost()
     * @return CHttpRequest
     */
    public static function getPost($name) {
        return Yii::app()->request->getPost($name);
    }

    /**
     * Выводит статистику использованных приложением ресурсов
     * @param boolean $return определяет возвращать результат или сразу выводить
     * @return string
     */
    public static function stats($return = false) {
        $db_stats = Yii::app()->db->getStats();

        if (is_array($db_stats)) {
            $db_stats = 'Выполнено запросов: ' . $db_stats[0] . ' (за ' . round($db_stats[1], 5) . ' сек.)<br />';
        }

        $memory = round(Yii::getLogger()->memoryUsage / 1024 / 1024, 3);
        $time = round(Yii::getLogger()->executionTime, 3);

        $result = $db_stats;
        $result .= 'Использовано памяти: ' . $memory . ' Мб<br />';
        $result .= 'Время выполнения: ' . $time . ' сек.';

        if ($return) {
            return $result;
        }

        echo $result;
    }

    /**
     * Возвращает URL, сформированный на основе указанного маршрута и параметров
     * @param string $route маршрут
     * @param array $params дополнительные параметры маршрута
     * @return string
     */
    public static function url($route, $params = array()) {
        if (is_object(Yii::app()->controller)) {
            return Yii::app()->controller->createUrl($route, $params);
        }

        return Yii::app()->createUrl($route, $params);
    }

    /**
     * Возвращает ссылку на компонент пользователя
     * @return CWebUser
     */
    public static function user() {
        return Yii::app()->user;
    }

    /**
     * Возвращает Id текущего пользователя, если он авторизован
     * @return mixed
     */
    public static function userId() {
        return Yii::app()->user->id;
    }

    public static function checkAccessLink($link) {
        if (self::isAdminUser(true)) {
            $access = EYii::param('u_info')->unserializedAccess;
            if (in_array($link, $access)) {
                return true;
            }
        }
        return false;
    }

    /* проверка на админа */

    public static function isAdminUser($bool = false) {
        if (EYii::isGuest()) {
            if ($bool == false)
                EYii::redir('/auth/logout');
            else
                return false;
        }
        if (EYii::hasAccess('administrator') != true && EYii::hasAccess('moderator') != true && EYii::hasAccess('helper') != true) {
            if ($bool == false)
                EYii::redir('/auth/logout');
            else
                return false;
        }
        if ($bool == true)
            return true;
    }

    public static function isOnlyAdmin() {
        if (EYii::isGuest()) {
            EYii::redir('/auth/logout');
        }
        if (EYii::hasAccess('administrator') != true) {
            EYii::redir('/auth/logout');
        }
    }

    public static function makeDirs($path, $mode = 0755, $recursive = true) {
        $dir = substr($path, 0, strripos($path, '/'));
        if (!file_exists($dir)) {
            mkdir($dir, $mode, $recursive);
        }
        return $path;
    }

    public static function generateCode($length = 7) {
        $num = range(0, 9);
        $symbols = array_merge($num);
        shuffle($symbols);
        $code_array = array_slice($symbols, 0, (int) $length);
        $code = implode("", $code_array);
        return $code;
    }

    public static function unserialize($data = null) {
        if ($data == null)
            return;
        $return = @unserialize($data);
        if (!$return) {
            $data = preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $data);
            $return = @unserialize($data);
        }
        return $return;
    }

    /*
     * @param string $date Дата в unixtime или datetime формате
     * @param string $type array('unixtime', 'datetime')
     */

    static function date($date = 'time()', $type = 'unixtime') {
        $curType = null;
        $return = false;
        if (preg_match('/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/', $date)) {
            $curType = 'datetime';
        } else if (((int) $date === $date) && ($date <= PHP_INT_MAX) && ($date >= ~PHP_INT_MAX)) {
            $curType = 'unixtime';
        }
        if ($curType) {
            if ($curType == $type)
                $return = $date;
            else {
                if ($type == 'unixtime')
                    $return = strtotime($date);
                elseif ($type == 'datetime')
                    $return = date("Y-m-d H:i:s", $date);
            }
        }
        return $return;
    }

    static function ErrorsToString($model) {
        $str = '';
        if ($model->errors) {
            foreach ($model->errors as $attribute => $errors) {
                $str .= $model->getAttributeLabel($attribute) . ": ";
                $str .= implode(', ', $errors);
                $str .= ". ";
            }
        }
        return $str;
    }

    static function listFromSimplyArrary($array) {
        $return = array();
        if ($array) {
            foreach ($array as $one) {
                $return[$one] = $one;
            }
        }
        return $return;
    }

    public static function is_assoc(array $array) {
        $keys = array_keys($array);
        return array_keys($keys) !== $keys;
    }

}
