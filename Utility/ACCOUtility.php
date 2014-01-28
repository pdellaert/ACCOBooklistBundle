<?php
namespace Dellaert\ACCOBooklistBundle\Utility;

class ACCOUtility {

	public static function verifyReferer($ref,$val) {
		preg_match("/https?:\/\/([a-zA-Z0-9\-\.]+)/", $ref, $matches);
		if( count($matches) > 1 && $matches[1] == $val ) {
			return true;
		}
		return false;
	}

    public static function getLiveSchoolsbyIdTitle($container,$locale) {
        // Getting Studies
        $url = $container->getParameter('dellaert_acco_booklist.kulapi.base');
        $url .= '/'.$locale.'/schools-id-title';
        $data = file_get_contents($url);

        if( $data === FALSE ) {
            $data = '';
        }
        $dataAr = json_decode($data,true);
        $result = array();
        foreach($dataAr as $school) {
            $result[$school['id']] = $school['title'];
        }

        return $result;
    }

    public static function getLiveStudiesByIdTitle($container,$locale,$scid,$fid,$lid) {
        // Getting Studies
        $url = $container->getParameter('dellaert_acco_booklist.kulapi.base');
        $url .= '/'.$locale.'/studies-id-title/'.$scid.'/'.$fid.'/'.$lid;
        $data = file_get_contents($url);

        if( $data === FALSE ) {
            $data = '';
        }

        return json_decode($data,true);
    }

    public static function getLiveProgramsByIdTitle($container,$locale,$scid,$sid) {
        // Getting Programs
        $url = $container->getParameter('dellaert_acco_booklist.kulapi.base');
        $url .= '/'.$locale.'/programs-id-title/'.$scid.'/'.$sid;
        $data = file_get_contents($url);

        if( $data === FALSE ) {
            $data = '';
        }

        return json_decode($data,true);
    }

    public static function getLiveStagesByIdTitle($container,$locale,$scid,$pid) {
        // Getting Stages
        $url = $container->getParameter('dellaert_acco_booklist.kulapi.base');
        $url .= '/'.$locale.'/stages-id-title/'.$scid.'/'.$pid;
        $data = file_get_contents($url);

        if( $data === FALSE ) {
            $data = '';
        }

        return json_decode($data,true);
    }

    public static function getLiveCoursesInLevel($container,$locale,$scid,$pid,$phid) {
        // Getting Courses
        $url = $container->getParameter('dellaert_acco_booklist.kulapi.base');
        $url .= '/'.$locale.'/courses-in-level/'.$scid.'/'.$pid.'/'.$phid;
        $data = file_get_contents($url);

        if( $data === FALSE ) {
            $data = '';
        }

        return json_decode($data,true);
    }

    public static function getLiveCourseDetails($container,$locale,$scid,$cid) {
        // Getting Courses
        $url = $container->getParameter('dellaert_acco_booklist.kulapi.base');
        $url .= '/'.$locale.'/course-details/'.$scid.'/'.$cid;
        $data = file_get_contents($url);

        if( $data === FALSE ) {
            $data = '';
        }

        return json_decode($data,true);
    }
}
