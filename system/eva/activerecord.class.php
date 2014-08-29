<?php
namespace Eva;
/**
 * Class ActiveRecord
 * TODO : Закончить код
 * @package Eva
 */
abstract class ActiveRecord extends Eva {
    /**
     * Магическая функция
     * @param $f
     * @param $a
     * @return $this|void
     */
    public function __call($f, $a) {
        $this->$f = array($a[0], $a[1]);
        return $this;
    }

    /**
     * Изменение названия таблицы в запросах
     * @param $i
     * @return $this
     */
    public function instance($i) {
        $this->instance = $i;
        return $this;
    }
    /**
     * Очистка добавленных параметров
     * @return $this
     */
    public function cleanup(){
        $this->__data__ = array();
        return $this;
    }

    /**
     * Задаёт Limit и Offset для запросов
     * @param $l
     * @param null $o
     * @return $this
     */
    public function limit($l, $o = NULL) {
        $this->limit = array($l, PDO::PARAM_INT);
        if($o != NULL) $this->offset = array($o, PDO::PARAM_INT);
        return $this;
    }

    /**
     * Задает Offset
     * @param $o
     * @return $this
     */
    public function offset($o) {
        $this->offset = array($o, PDO::PARAM_INT);
        return $this;
    }

    /**
     * Выборка из БД
     * @param string $what
     * @return null
     */
    public function select($what = '*'){
        return $this->exec('SELECT '.$what.' FROM '.$this->instance);
    }

    /**
     * Обновление данных в БД
     * @param $a Наимменование полея для обновления
     * @return null
     */
    public function update($a) {
        $sth = 'UPDATE '.$this->instance;
        /**
         * Из списка параметров для обновления ($a) формируем запрос типа SET k = :k, k2 = :k2
         */
        $temp = array();
        foreach($a as $k => $v) {
            $temp []= $v.' = :'.$v; 
        };

        return $this->exec($sth.' SET '.join(',', $temp));
    }

    /**
     * Добавление новой записи в БД
     * @return null
     */
    public function insert() {
        $sth = 'INSERT INTO '.$this->instance;
        unset($this->instance);

        /**
         * Из списка параметров формируем запрос типа
         * INSERT INTO $instance ($keys) VALUES($value)
         */
        $values = array();
        $keys = array();
        foreach($this->__data__ as $k => $v) {
            $keys[]= $k;
            $values[]= ':'.$k;
        };
        return $this->exec($sth.' ('.join(',', $keys).') VALUES('.join(',', $values).')');
    }

    /**
     * Удаление записи из БД
     * @return null
     */
    public function delete() {
        return $this->exec('DELETE FROM '.$this->instance);
    }

    /**
     * Подготовка и выполнения запроса
     * На этой стадии добавляется Where, Limit, Group, Order
     * @param $statement
     * @return null
     */
    protected function exec($statement){
        /**
         * Блок подготовки WHERE
         */
        unset($this->instance);
        $this->where = $this->where[0];
        foreach($this->__data__ as $k => $v) {
            if(!is_array($v[0])) continue;
            if($v[1] == PDO::PARAM_INT) {
                foreach($v[0] as $k2 => $v2)
                    if(!is_numeric($v2)) return NULL;
            };
            $this->where = str_replace(':'.$k, join(',', $v[0]), $this->where);
            unset($this->__data__[$k]);
        };
        if(isset($this->where{2}))
            $statement .= ' WHERE '.$this->where;
        unset($this->where);

        /**
         * Блок подготовки Group By и Order By
         */
        if(isset($this->groupby[0])) $statement .= ' GROUB BY '.$this->groupby[0];
        if(isset($this->orderby[0])) $statement .= ' ORDER BY '.$this->orderby[0];
        unset($this->orderby, $this->groupby);

        /**
         * Блок подготовки Limit
         */
        if($this->limit) {
            /**
             * Если есть Offset и Limit то Limit считается "страницей", т.е.
             * Limit = Limit * Offset
             */
            if($this->offset) {
                $this->__data__['limit'][0] = $this->limit[0] * $this->offset[0];
                $statement .= ' LIMIT :limit, :offser';
            } else {
                $statement .= ' LIMIT :limit';
            };
        };
        /**
         * Магия PDO
         */
        $sth = \app::$db->prepare($statement);
        foreach($this->__data__ as $k => $v) {
            $sth->bindParam(':'.$k, $v[0], $v[1] ? $v[1] : PDO::PARAM_STR);
        };
        $sth->execute();
        $this->cleanup();
        /**
         * Если ошибок нет, выводим результат
         */
        if($sth->errorCode() == '00000') {
            return $sth->fetchAll(PDO::FETCH_ASSOC);
        };
        // TODO Написать класс логов с возможностью отправки логов по email
        error_log('PDO::Error with statement '.$statement);
    }

};

/// 2014 | AeonRUSH |