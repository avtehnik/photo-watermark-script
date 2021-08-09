# photo-watermark-script

`docker image build -t  watermark .`

`docker run -it  --mount src="$(pwd)",target=/srv/project,type=bind watermark watermark _MG_8303.JPG`