# photo-watermark-script

`docker image build -t  watermark .`

`docker run -it  --mount src="$(pwd)",target=/srv/project,type=bind watermark watermark _MG_8303.JPG`

`docker run -it  --mount src="$(pwd)",target=/srv/project,type=bind ghcr.io/avtehnik/watermark:2021-08-09-6 watermark _MG_8303.JPG`
