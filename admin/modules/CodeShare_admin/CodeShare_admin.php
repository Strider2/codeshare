<?php


class CodeShare_admin extends CodonModule
{
    public function HTMLHead()
    {
        $this->set('sidebar', 'codeshare/sidebar_codeshare.php');
    }

    public function NavBar()
    {
        echo '<li><a href="'.SITE_URL.'/admin/index.php/codeshare_admin">Codeshares</a></li>';
    }

    public function index()
    {
        if($this->post->action == 'save_new_codeshare')
        {
            $this->save_new_codeshare();
        }
        elseif($this->post->action == 'save_edit_codeshare')
        {
            $this->save_edit_codeshare();
        }
        elseif($this->post->action == 'save_new_codeshare_airline')
        {
            $this->save_new_codeshare_airline();
        }
        elseif($this->post->action == 'save_edit_codeshare_airline')
        {
            $this->save_edit_codeshare_airline();
        }
        else
        {
            $this->set('codeshare', CodeShareData::get_codeshare());
			      $this->set('history', CodeShareData::get_past_codeshare());
            $this->set('copyright', CodeShareData::getVersion());
            $this->show('codeshare/codeshare_index.php');
        }
    }
    public function get_codeshares()
    {
        $id = $_GET[id];
        $this->set('codeshare', CodeShareData::get_codeshares($id));
        $this->set('allairports', OperationsData::GetAllAirports());
        $this->set('allaircraft', OperationsData::GetAllAircraft());
        $this->show('codeshare/codeshares_codeshare.php');
    }
    public function new_codeshare()
    {
        $codeshare = CodeShareData::get_schedules();
        $this->checkPermission(EDIT_SCHEDULES);
        $this->set('title', 'Add Codeshare');
        $this->set('action', 'save_new_codeshare');

        if ($this->get->reverse == '1') {
            $codeshare = SchedulesData::GetSchedule($this->get->id);

            # Reverse stuffs
            unset($codeshare->id);

            $codeshare->flightnum = '';

            $tmp = $codeshare->depicao;
            $codeshare->depicao = $codeshare->arricao;
            $codeshare->arricao = $tmp;

            if($codeshare->route != '') {
                $route = @explode(' ', $codeshare->route);
                if(is_array($route)) {
                    $route = array_reverse($route);
                    $codeshare->route = $route;
                }
            }

            $codeshare->distance = OperationsData::getAirportDistance($codeshare->depicao, $codeshare->arricao);

            $this->set('codeshare', $codeshare);
        }

        $this->set('allairlines', CodeShareData::get_codeshare_airline());
        $this->set('allaircraft', OperationsData::GetAllAircraft());
        $this->set('allairports', OperationsData::GetAllAirports());
        //$this->set('airport_json_list', OperationsData::getAllAirportsJSON());
        $this->set('flighttypes', Config::Get('FLIGHT_TYPES'));

        $this->render('codeshare/codeshare_new_form.php');
        /*$this->set('codeshares', $codeshares);
        $this->show('codeshare/codeshare_new_form.php');*/
    }
    /**
     * Operations::calculatedistance()
     *
     * @param string $depicao
     * @param string $arricao
     * @return
     */
    public function calculatedistance($depicao = '', $arricao = '') {

        if ($depicao == '') $depicao = $this->get->depicao;
        if ($arricao == '') $arricao = $this->get->arricao;

        echo OperationsData::getAirportDistance($depicao, $arricao);
    }

    /**
     * Operations::findairport()
     *
     * @return
     */
    public function findairport() {

        $results = OperationsData::searchAirport($this->get->term);

        if (count($results) > 0) {
            $return = array();

            foreach ($results as $row) {
               $return[] = array(
                    'label' => "{$row->icao} ({$row->name})",
                    'value' => $row->icao,
                    'id' => $row->id,
                );
            }

            echo json_encode($return);
        }
    }
    public function codes($type = 'activeschedules') {
        $this->checkPermission(EDIT_SCHEDULES);
        $this->set('codeshare', $codeshare);
        /* These are loaded in popup box */
        if ($this->get->action == 'viewroute') {
            $id = $this->get->id;
            return;
        }


        if ($this->get->action == 'filter') {

            $this->set('title', 'Filtered Schedules');

            if ($this->get->type == 'flightnum') {
                $params = array('s.flightnum' => $this->get->query);
            } elseif ($this->get->type == 'code') {
                $params = array('s.code' => $this->get->query);
            } elseif ($this->get->type == 'aircraft') {
                $params = array('a.name' => $this->get->query);
            } elseif ($this->get->type == 'depapt') {
                $params = array('s.depicao' => $this->get->query);
            } elseif ($this->get->type == 'arrapt') {
                $params = array('s.arricao' => $this->get->query);
            }

            // Filter or don't filter enabled/disabled flights
            if (isset($this->get->enabled) && $this->get->enabled != 'all') {
                $params['s.enabled'] = $this->get->enabled;
            }

            $this->set('codeshares', SchedulesData::findSchedules($params));
            $this->render('ops_schedules.php');
            return;
        }

        switch ($this->post->action) {
            case 'new_codeshare':
                $this->save_new_codeshare();
                break;

            case 'editschedule':
                $this->edit_schedule_post();
                break;

            case 'deleteschedule':
                $this->delete_schedule_post();
                return;
                break;
        }

        if (!isset($this->get->start) || $this->get->start == '') {
            $this->get->start = 0;
        }

        $num_per_page = 20;
        $start = $num_per_page * $this->get->start;

        if ($type == 'schedules' || $type == 'activeschedules') {
            $params = array('s.enabled' => 1);
            $codeshare = SchedulesData::findSchedules($params, $num_per_page, $start);

            $this->set('title', 'Viewing Active Codeshares');
            $this->set('codeshares', $codeshares);

            if (count($codeshares) >= $num_per_page) {

                $this->set('paginate', true);
                $this->set('start', $this->get->start + 1);

                if ($this->get->start - 1 > 0) {

                    $prev = $this->get->start - 1;
                    if ($prev == '') $prev = 0;

                    $this->set('prev', intval($prev));
                }
            }
        } else {
            $this->set('title', 'Viewing Inactive Schedules');
            $this->set('codeshares', SchedulesData::findSchedules(array('s.enabled' => 0)));
        }

        $this->render('codeshare/codeshare_index.php');
    }
    protected function save_new_codeshare()
    {
      $this->checkPermission(EDIT_SCHEDULES);
      $codeshare = array();

      $codeshare['code'] = DB::escape($this->post->code);
      $codeshare['flightnum'] = DB::escape($this->post->flightnum);
      $codeshare['depicao'] = DB::escape($this->post->depicao);
      $codeshare['arricao'] = DB::escape($this->post->arricao);
      $codeshare['deptime'] = DB::escape($this->post->deptime);
      $codeshare['arrtime'] = DB::escape($this->post->arrtime);
      $codeshare['daysofweek'] = DB::escape($this->post->daysofweek);
      $codeshare['distance'] = DB::escape($this->post->distance);
      $codeshare['flighttime'] = DB::escape($this->post->flighttime);
      $codeshare['aircraft'] = DB::escape($this->post->aircraft);
      $codeshare['flightlevel'] = DB::escape($this->post->flightlevel);
      $codeshare['flighttype'] = DB::escape($this->post->flighttype);
      $codeshare['route'] = DB::escape($this->post->route);
      $codeshare['price'] = DB::escape($this->post->price);
      $codeshare['enabled'] = DB::escape($this->post->enabled);
      $codeshare['codeshare'] = DB::escape($this->post->codeshare);
      $codeshare['codenum'] = DB::escape($this->post->codenum);


      foreach($codeshare as $test)
      {
          if(empty($test))
          {
              $this->set('codeshare', $codeshare);
              $this->show('codeshare/codeshare_new_form.php');
              return;
          }
      }


      # Add it in
      $ret = CodeShareData::save_new_codeshare($codeshare['code'], $codeshare['flightnum'],
                            $codeshare['depicao'],
                            $codeshare['arricao'],
                            $codeshare['deptime'],
                            $codeshare['arrtime'],
                            $codeshare['daysofweek'],
                            $codeshare['distance'],
                            $codeshare['flighttime'],
                            $codeshare['aircraft'],
                            $codeshare['flightlevel'],
                            $codeshare['flighttype'],
                            $codeshare['route'],
                            $codeshare['price'],
                            $codeshare['enabled'],
                            $codeshare['codeshare'],
                            $codeshare['codenum']);

      if (DB::errno() != 0 && $ret == false) {
          $this->set('message',
              'There was an error adding the schedule, already exists DB error: ' . DB::error
              ());
          $this->render('core_error.php');
          return;
      }

      $this->set('message', 'The schedule "' . $this->post->code . $this->post->flightnum .
          '" has been added');
      $this->render('core_success.php');

      LogData::addLog(Auth::$userinfo->pilotid, 'Added codeshare "' . $this->post->code .
          $this->post->flightnum . '"');
    }
    public function edit_codeshare() {
            $id = $_GET[id];
            $codeshare = array();
            $codeshare = CodeShareData::get_codeshares($id);
            $this->set('allairlines', CodeShareData::get_codeshare_airline());
            $this->set('codeshare', $codeshare);
            $this->show('codeshare/codeshare_edit_form.php');
    }
    protected function save_edit_codeshare()
    {
      $this->checkPermission(EDIT_SCHEDULES);
      $codeshare = array();

      $codeshare['code'] = DB::escape($this->post->code);
      $codeshare['flightnum'] = DB::escape($this->post->flightnum);
      $codeshare['depicao'] = DB::escape($this->post->depicao);
      $codeshare['arricao'] = DB::escape($this->post->arricao);
      $codeshare['deptime'] = DB::escape($this->post->deptime);
      $codeshare['arrtime'] = DB::escape($this->post->arrtime);
      $codeshare['daysofweek'] = DB::escape($this->post->daysofweek);
      $codeshare['distance'] = DB::escape($this->post->distance);
      $codeshare['flighttime'] = DB::escape($this->post->flighttime);
      $codeshare['aircraft'] = DB::escape($this->post->aircraft);
      $codeshare['flightlevel'] = DB::escape($this->post->flightlevel);
      $codeshare['flighttype'] = DB::escape($this->post->flighttype);
      $codeshare['route'] = DB::escape($this->post->route);
      $codeshare['price'] = DB::escape($this->post->price);
      $codeshare['enabled'] = DB::escape($this->post->enabled);
      $codeshare['codeshare'] = DB::escape($this->post->codeshare);
      $codeshare['codenum'] = DB::escape($this->post->codenum);


        $ret=CodeShareData::save_edit_codeshare($codeshare['code'], $codeshare['flightnum'],
                              $codeshare['depicao'],
                              $codeshare['arricao'],
                              $codeshare['deptime'],
                              $codeshare['arrtime'],
                              $codeshare['daysofweek'],
                              $codeshare['distance'],
                              $codeshare['flighttime'],
                              $codeshare['aircraft'],
                              $codeshare['flightlevel'],
                              $codeshare['flighttype'],
                              $codeshare['route'],
                              $codeshare['price'],
                              $codeshare['enabled'],
                              $codeshare['codeshare'],
                              $codeshare['codenum']);

        if (DB::errno() != 0 && $ret == false) {
            $this->set('message',
                       'There was an error adding the schedule,
                       already exists DB error: ' . DB::error());
            $this->render('core_error.php');
            return;
        }

        $this->set('message', 'The schedule "' . $this->post->code . $this->post->flightnum .
                   '" has been added');
        $this->render('core_success.php');

        LogData::addLog(Auth::$userinfo->pilotid, 'Added codeshare "' . $this->post->code .
                        $this->post->flightnum . '"');

        $id = $codeshare['id'];
        $this->set('codeshare', CodeShareData::get_codeshares($id));

        $this->show('codeshare/codeshares_codeshare.php');
    }

    public function delete_codeshare()
    {
        $id = $_GET[id];
        CodeShareData::delete_codeshare($id);

        $this->set('codeshare', CodeShareData::get_upcoming_codeshares());
        $this->show('codeshare/codeshare_index.php');
    }
    public function airline()
    {
        if($this->post->action == 'save_new_codeshare_airline')
        {
            $this->save_new_codeshare_airline();
        }
        elseif($this->post->action == 'save_edit_codeshare_airline')
        {
            $this->save_edit_codeshare_airline();
        }
        else
        {
            $this->set('airlines', CodeShareData::get_upcoming_codeshare_airlines());
            $this->set('history', CodeShareData::get_past_codeshare());
            $this->set('copyright', CodeShareData::getVersion());
            $this->show('codeshare/airline/airline_index.php');
        }
    }
    public function new_codeshare_airline()
    {
        $this->set('airlines', $airlines);
        $this->show('codeshare/airline/airline_new_form.php');
    }
    public function get_codeshare_airlines()
    {
        $code = $_GET[code];
        $this->set('airlines', CodeShareData::get_codeshare_airlines($code));

        $this->show('codeshare/airline/airlines_airline.php');
    }
    public function save_new_codeshare_airline()
    {
      $this->checkPermission(EDIT_AIRLINES);
      $airlines = array();

      $airlines['code'] = DB::escape($this->post->code);
      $airlines['name'] = DB::escape($this->post->name);
      $airlines['codeshare'] = DB::escape($this->post->codeshare);
      $airlines['airdesc'] = DB::escape($this->post->airdesc);
      $airlines['type'] = DB::escape($this->post->type);
      $airlines['enabled'] = DB::escape($this->post->enabled);




      foreach($airlines as $airline)
      {
          if(empty($airline))
          {
              $this->set('airline', $airline);
              $this->show('codeshare/airline/airline_new_form.php');
              return;
          }
      }



      $ret = CodeShareData::save_codeshare_airline($airlines['code'], $airlines['name'],
                      $airlines['codeshare'],
                      $airlines['airdesc'],
                      $airlines['type'],
                      $airlines['enabled']);

                      if (DB::errno() != 0 && $ret == false) {
                          $this->set('message',
                              'There was an error adding the Codeshare Airline, already exists DB error: ' . DB::error
                              ());
                          $this->render('core_error.php');
                          return;
                      }

                      $this->set('message', 'The codeshare airline "' . $this->post->code .' - '. $this->post->name .
                          '" has been added');
                      $this->render('core_success.php');

      LogData::addLog(Auth::$userinfo->pilotid, 'Added a codeshare airline "' . $this->post->code . ' - '.$this->post->name . '"');
      $this->set('airlines', CodeShareData::get_upcoming_codeshare_airlines());

      $this->show('codeshare/airline/airline_index.php');
    }
    public function edit_codeshare_airline() {
            $aircode = $_GET[code];
            $airlines = array();
            $airlines = CodeShareData::get_codeshare_airlines($aircode);
            $this->set('airlines', $airlines);
            $this->show('codeshare/airline/airline_edit_form.php');
    }
    public function save_edit_codeshare_airline()
    {
        $airlines = array();


        $airlines['code'] = DB::escape($this->post->code);
        $airlines['name'] = DB::escape($this->post->name);
        $airlines['codeshare'] = DB::escape($this->post->codeshare);
        $airlines['airdesc'] = DB::escape($this->post->airdesc);
        $airlines['type'] = DB::escape($this->post->type);
        $airlines['enabled'] = DB::escape($this->post->enabled);



        CodeShareData::save_edit_codeshare_airline($airlines['code'],
                       $airlines['name'],
                       $airlines['codeshare'],
                       $airlines['airdesc'],
                       $airlines['type'],
                       $airlines['enabled']);

        $aircode = $airlines['code'];
        $this->set('airlines', CodeShareData::get_codeshare_airlines($aircode));

        $this->show('codeshare/airline/airlines_airline.php');
    }
    public function delete_codeshare_airline()
    {
        $airid = $_GET[id];
        CodeShareData::delete_codeshare_airline($airid);

        $this->set('codeshare', CodeShareData::get_upcoming_codeshares());
        $this->show('codeshare/codeshare_index.php');
    }
}
