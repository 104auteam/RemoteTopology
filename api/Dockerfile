FROM python:3.8

COPY ./data /app
WORKDIR /app

RUN pip install --upgrade pip setuptools
RUN pip install --upgrade git+https://github.com/vmware/vsphere-automation-sdk-python.git
RUN pip install -r requirements.txt

CMD ["python", "./app.py"]