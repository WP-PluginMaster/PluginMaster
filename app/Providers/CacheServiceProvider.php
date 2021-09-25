<?php


namespace PluginMaster\App\Providers;


use PluginMaster\Contracts\Provider\ServiceProviderInterface;

class CacheServiceProvider implements ServiceProviderInterface
{

    public function boot() {

        //   Cache::set('route', "hello", "view") ;

        //  error_log( Cache::get('route' , "view") );
        //  $this->createFile( 'route', "Hello", 'view' );


    }

    public function generateFileName( $fileName ) {
        return hash( 'md5', $fileName );
    }

    public function createFile( $fileName, $content, $directory = null ) {

        $this->createDirectory( $directory );
        $hashFile = hash( 'md5', $fileName );
        $fullPath = $this->cachePath( ($directory ? DIRECTORY_SEPARATOR . $directory : '') . DIRECTORY_SEPARATOR . $hashFile );
        return file_put_contents( $fullPath, $content );
    }

    public function createDirectory( $path ) {
        $fullPath = $this->cachePath( $path );

        if ( !$this->isExist( $fullPath ) ) {
            return mkdir( $fullPath, 0755 );
        }
        return true;
    }

    public function isExist( $path ) {
        return file_exists( $path );
    }

    private function get( $fileName, $directory = null ) {
        $hashFile = hash( 'md5', $fileName );
        $fullPath = $this->cachePath( ($directory ? DIRECTORY_SEPARATOR . $directory : '') . DIRECTORY_SEPARATOR . $hashFile );
        return file_get_contents( $fullPath );
    }

    private function cachePath( $path = null ) {
        return wp_upload_dir()['basedir'] . DIRECTORY_SEPARATOR . 'plugin-master' . ($path ? DIRECTORY_SEPARATOR . $path : '');
    }


}
